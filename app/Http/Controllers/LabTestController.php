<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLabTestRequest;
use App\Http\Requests\UpdateLabTestRequest;
use App\Models\LabTest;
use App\Services\ExportService;
use App\Services\ImportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LabTestController extends Controller
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

        $query = LabTest::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('test', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        $tests = $query->orderBy($sortBy, $direction)->paginate($perPage)->appends($request->except('page'));

        return view('lab-tests.index', compact('tests', 'search', 'sortBy', 'direction'));
    }

    public function create(): View
    {
        return view('lab-tests.create');
    }

    public function store(StoreLabTestRequest $request): RedirectResponse
    {
        LabTest::create($request->validated());

        return redirect()->route('lab-tests.index')->with('success', 'Lab Test created successfully!');
    }

    public function edit($id): View
    {
        $test = LabTest::findOrFail($id);

        return view('lab-tests.edit', compact('test'));
    }

    public function update(UpdateLabTestRequest $request, $id): RedirectResponse
    {
        $test = LabTest::findOrFail($id);

        $test->update($request->validated());

        return redirect()->route('lab-tests.index')->with('success', 'Lab Test updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $test = LabTest::findOrFail($id);
            $test->delete();

            return redirect()->route('lab-tests.index')->with('success', 'Lab Test deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('lab-tests.index')->with('error', 'Error deleting lab test. Please try again.');
        }
    }

    public function search(Request $request)
    {
        $term = $request->input('q', '');
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 25);

        $query = LabTest::query();

        if ($term) {
            $query->where(function ($q) use ($term) {
                $q->where('test', 'like', "%{$term}%")
                  ->orWhere('code', 'like', "%{$term}%")
                  ->orWhere('department', 'like', "%{$term}%");
            });
        }

        $tests = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data' => $tests->items(),
            'meta' => [
                'current_page' => $tests->currentPage(),
                'last_page' => $tests->lastPage(),
                'per_page' => $tests->perPage(),
                'total' => $tests->total(),
                'from' => $tests->firstItem(),
                'to' => $tests->lastItem(),
            ],
        ]);
    }

    public function import(Request $request): RedirectResponse
    {
        $columnMap = [
            'department' => 0,
            'sample_type' => 1,
            'panel' => 2,
            'test' => 3,
            'code' => 4,
            'unit' => 5,
            'result_type' => 6,
            'normal_range' => 7,
        ];

        $totalImported = $this->importService->importFromFile($request, new LabTest, $columnMap);

        if ($totalImported === 0) {
            return redirect()->route('lab-tests.index')->with('error', 'File is empty or could not be read.');
        }

        return redirect()->route('lab-tests.index')->with('success', "{$totalImported} lab tests imported successfully!");
    }

    public function template(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="lab_test_template.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['department', 'sample_type', 'panel', 'test', 'code', 'unit', 'result_type', 'normal_range']);
            fputcsv($handle, ['Pathology', 'Blood', 'Lipid Profile', 'Cholesterol', 'CHOL-001', 'mg/dL', 'Numeric', '0-200']);
            fclose($handle);
        }, 200, $headers);
    }

    public function export(Request $request): StreamedResponse
    {
        $search = $request->input('search', '');
        $query = LabTest::query();

        if ($search) {
            $query->where('test', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")
                ->orWhere('department', 'like', "%{$search}%");
        }

        $columns = [
            'department' => 'department',
            'sample_type' => 'sample_type',
            'panel' => 'panel',
            'test' => 'test',
            'code' => 'code',
            'unit' => 'unit',
            'result_type' => 'result_type',
            'normal_range' => 'normal_range',
        ];

        return $this->exportService->exportToCsv($query, $columns, 'lab_tests_export.csv');
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term', '');
        $tests = LabTest::where(function ($q) use ($term) {
                $q->where('test', 'like', "%{$term}%")
                  ->orWhere('code', 'like', "%{$term}%")
                  ->orWhere('department', 'like', "%{$term}%");
            })
            ->orderByRaw("CASE 
                WHEN test LIKE '{$term}%' THEN 1
                WHEN test LIKE '%{$term}%' THEN 2
                WHEN code LIKE '{$term}%' THEN 3
                WHEN code LIKE '%{$term}%' THEN 4
                ELSE 5 
            END")
            ->orderBy('test')
            ->get(['id', 'test', 'code', 'department']);

        return response()->json([
            'success' => true,
            'data' => $tests,
        ]);
    }

    public function show($id): View
    {
        $test = LabTest::findOrFail($id);

        return view('lab-tests.show', compact('test'));
    }

    public function downloadDuplicates()
    {
        if (!session('duplicate_rows')) {
            return redirect()->route('lab-tests.index')->with('error', 'No duplicate data found.');
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="lab_test_duplicates.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['department', 'sample_type', 'panel', 'test', 'code', 'unit', 'result_type', 'normal_range']);
            foreach (session('duplicate_rows') as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, 200, $headers);
    }

    public function downloadFailed()
    {
        if (!session('failed_rows')) {
            return redirect()->route('lab-tests.index')->with('error', 'No failed data found.');
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="lab_test_failed.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['department', 'sample_type', 'panel', 'test', 'code', 'unit', 'result_type', 'normal_range']);
            foreach (session('failed_rows') as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, 200, $headers);
    }
}
