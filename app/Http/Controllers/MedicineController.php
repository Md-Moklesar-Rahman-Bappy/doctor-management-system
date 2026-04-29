<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;
use App\Models\Medicine;
use App\Services\ExportService;
use App\Services\ImportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MedicineController extends Controller
{
    protected ImportService $importService;

    protected ExportService $exportService;

    public function __construct(ImportService $importService, ExportService $exportService)
    {
        $this->middleware('auth')->except(['autocomplete', 'search']);
        $this->importService = $importService;
        $this->exportService = $exportService;
    }

    public function index(Request $request): View
    {
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 25);
        $sortBy = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');

        $query = Medicine::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('brand_name', 'like', "%{$search}%")
                    ->orWhere('generic_name', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        $medicines = $query->orderBy($sortBy, $direction)->paginate($perPage)->appends($request->except('page'));

        return view('medicines.index', compact('medicines', 'search'));
    }

    public function create(): View
    {
        return view('medicines.create');
    }

    public function store(StoreMedicineRequest $request): RedirectResponse
    {
        Medicine::create($request->validated());

        return redirect()->route('medicines.index')->with('success', 'Medicine created successfully!');
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

        return redirect()->route('medicines.index')->with('success', 'Medicine updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $medicine = Medicine::findOrFail($id);
            $medicine->delete();

            return redirect()->route('medicines.index')->with('success', 'Medicine deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('medicines.index')->with('error', 'Error deleting medicine. Please try again.');
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
        $columnMap = [
            'brand_name' => 0,
            'generic_name' => 1,
            'dosage_type' => 2,
            'strength' => 3,
            'company_name' => 4,
            'package_mark' => 5,
        ];

        $totalImported = $this->importService->importFromFile($request, new Medicine, $columnMap);

        if ($totalImported === 0) {
            return redirect()->route('medicines.index')->with('error', 'File is empty or could not be read.');
        }

        return redirect()->route('medicines.index')->with('success', "{$totalImported} medicines imported successfully!");
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

        $columns = [
            'brand_name' => 'brand_name',
            'generic_name' => 'generic_name',
            'dosage_type' => 'dosage_type',
            'strength' => 'strength',
            'company_name' => 'company_name',
            'package_mark' => 'package_mark',
        ];

        return $this->exportService->exportToCsv($query, $columns, 'medicines_export.csv');
    }
}
