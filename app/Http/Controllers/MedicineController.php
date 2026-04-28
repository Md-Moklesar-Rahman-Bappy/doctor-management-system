<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MedicineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['autocomplete', 'search']);
    }

    public function index(Request $request): View
    {
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 25);

        $query = Medicine::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('brand_name', 'like', "%{$search}%")
                    ->orWhere('generic_name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        $medicines = $query->orderBy('id', 'desc')->paginate($perPage)->appends($request->except('page'));

        return view('medicines.index', compact('medicines', 'search'));
    }

    public function create(): View
    {
        return view('medicines.create');
    }

    public function store(StoreMedicineRequest $request): RedirectResponse
    {
        Medicine::create($request->validated());

        return redirect('/medicines')->with('success', 'Medicine created successfully!');
    }

    public function show($id): View
    {
        $medicine = Medicine::findOrFail($id);

        return view('medicines.show', compact('medicine'));
    }

    public function edit($id): View
    {
        $medicine = Medicine::findOrFail($id);

        return view('medicines.edit', compact('medicine'));
    }

    public function update(UpdateMedicineRequest $request, $id): RedirectResponse
    {
        $medicine = Medicine::findOrFail($id);

        $medicine->update($request->validated());

        return redirect('/medicines')->with('success', 'Medicine updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $medicine = Medicine::findOrFail($id);
            $medicine->delete();

            return redirect('/medicines')->with('success', 'Medicine deleted successfully!');
        } catch (\Exception $e) {
            return redirect('/medicines')->with('error', 'Error deleting medicine. Please try again.');
        }
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q', '');
        $medicines = Medicine::where('brand_name', 'like', "%{$query}%")
            ->orWhere('company_name', 'like', "%{$query}%")
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $medicines,
        ]);
    }

    public function autocomplete(Request $request): JsonResponse
    {
        $term = $request->input('term', '');
        $medicines = Medicine::where('brand_name', 'like', "%{$term}%")
            ->orWhere('generic_name', 'like', "%{$term}%")
            ->orWhere('company_name', 'like', "%{$term}%")
            ->limit(10)
            ->get(['id', 'brand_name', 'generic_name', 'dosage_type', 'company_name']);

        return response()->json([
            'success' => true,
            'data' => $medicines,
        ]);
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls,txt|max:51200',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $extension = $file->getClientOriginalExtension();

        $rows = [];

        if (in_array($extension, ['xlsx', 'xls'])) {
            $spreadsheet = IOFactory::load($path);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
        } else {
            if (($handle = fopen($path, 'r')) !== false) {
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    $rows[] = $data;
                }
                fclose($handle);
            }
        }

        if (empty($rows)) {
            return redirect('/medicines')->with('error', 'File is empty or could not be read.');
        }

        array_shift($rows); // Skip header

        $batchSize = 500;
        $batches = array_chunk($rows, $batchSize);
        $totalImported = 0;

        foreach ($batches as $batch) {
            $records = [];
            foreach ($batch as $data) {
                if (empty($data[0])) {
                    continue;
                }

                $records[] = [
                    'brand_name' => $data[0] ?? '',
                    'generic_name' => $data[1] ?? '',
                    'dosage_type' => $data[2] ?? '',
                    'strength' => $data[3] ?? '',
                    'company_name' => $data[4] ?? '',
                    'package_mark' => $data[5] ?? '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (! empty($records)) {
                Medicine::insert($records);
                $totalImported += count($records);
            }
        }

        return redirect('/medicines')->with('success', "{$totalImported} medicines imported successfully!");
    }

    public function template(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="medicine_template.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['brand_name', 'generic_name', 'dosage_type', 'strength', 'company_name', 'package_mark']);
            fputcsv($handle, ['Paracetamol', 'Acetaminophen', 'Tablet', '500mg', 'GSK', 'Strip']);
            fclose($handle);
        }, 200, $headers);
    }

    public function export(Request $request): StreamedResponse
    {
        $search = $request->input('search', '');
        $query = Medicine::query();

        if ($search) {
            $query->where('brand_name', 'like', "%{$search}%")
                ->orWhere('generic_name', 'like', "%{$search}%")
                ->orWhere('company_name', 'like', "%{$search}%");
        }

        $medicines = $query->orderBy('id', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="medicines_export.csv"',
        ];

        return response()->stream(function () use ($medicines) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['brand_name', 'generic_name', 'dosage_type', 'strength', 'company_name', 'package_mark']);

            foreach ($medicines as $medicine) {
                fputcsv($handle, [
                    $medicine->brand_name,
                    $medicine->generic_name,
                    $medicine->dosage_type,
                    $medicine->strength,
                    $medicine->company_name,
                    $medicine->package_mark,
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }
}
