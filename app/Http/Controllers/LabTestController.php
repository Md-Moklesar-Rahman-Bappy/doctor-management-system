<?php

namespace App\Http\Controllers;

use App\Models\LabTest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LabTestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['autocomplete', 'search']);
    }

    public function index(Request $request): View
    {
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 25);

        $query = LabTest::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('test', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }

        $tests = $query->orderBy('id', 'desc')->paginate($perPage)->appends($request->except('page'));

        return view('lab_tests.index', compact('tests', 'search'));
    }

    public function create(): View
    {
        return view('lab_tests.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'department' => 'required|string|max:255',
            'sample_type' => 'required|string|max:255',
            'panel' => 'nullable|string|max:255',
            'test' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:lab_tests',
            'unit' => 'nullable|string|max:50',
            'result_type' => 'nullable|string|max:50',
            'normal_range' => 'nullable|string|max:255',
        ]);

        LabTest::create($validated);

        return redirect('/lab_tests')->with('success', 'Lab Test created successfully!');
    }

    public function edit($id): View
    {
        $test = LabTest::findOrFail($id);
        return view('lab_tests.edit', compact('test'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $test = LabTest::findOrFail($id);

        $validated = $request->validate([
            'department' => 'required|string|max:255',
            'sample_type' => 'required|string|max:255',
            'panel' => 'nullable|string|max:255',
            'test' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:lab_tests,code,' . $id,
            'unit' => 'nullable|string|max:50',
            'result_type' => 'nullable|string|max:50',
            'normal_range' => 'nullable|string|max:255',
        ]);

        $test->update($validated);

        return redirect('/lab_tests')->with('success', 'Lab Test updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $test = LabTest::findOrFail($id);
            $test->delete();

            return redirect('/lab_tests')->with('success', 'Lab Test deleted successfully!');
        } catch (\Exception $e) {
            return redirect('/lab_tests')->with('error', 'Error deleting lab test. Please try again.');
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
            ]
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

        try {
            if (in_array($extension, ['xlsx', 'xls'])) {
                $spreadsheet = IOFactory::load($path);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
            } else {
                if (($handle = fopen($path, 'r')) !== false) {
                    // Detect delimiter
                    $delimiters = [',', ';', "\t", '|'];
                    $firstLine = fgets($handle);
                    rewind($handle);

                    $delimiter = ',';
                    if ($firstLine) {
                        $maxCount = 0;
                        foreach ($delimiters as $delim) {
                            $count = count(str_getcsv($firstLine, $delim));
                            if ($count > $maxCount) {
                                $maxCount = $count;
                                $delimiter = $delim;
                            }
                        }
                    }

                    // Skip BOM if present
                    $bom = fread($handle, 3);
                    if ($bom !== "\xEF\xBB\xBF") {
                        rewind($handle);
                    }

                    while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
                        $rows[] = $data;
                    }
                    fclose($handle);
                }
            }
        } catch (\Exception $e) {
            return redirect('/lab_tests')->with('error', 'Error reading file: ' . $e->getMessage());
        }

        if (empty($rows)) {
            return redirect('/lab_tests')->with('error', 'File is empty or could not be read.');
        }

        // Remove header row if present
        if (count($rows) > 0) {
            $firstRow = $rows[0];
            $headerIndicators = ['department', 'test', 'code', 'sample_type'];
            $isHeader = false;
            foreach ($headerIndicators as $indicator) {
                foreach ($firstRow as $cell) {
                    if (is_string($cell) && stripos(trim($cell), $indicator) !== false) {
                        $isHeader = true;
                        break 2;
                    }
                }
            }
            if ($isHeader) {
                array_shift($rows);
            }
        }

        if (empty($rows)) {
            return redirect('/lab_tests')->with('error', 'No data found after removing header row.');
        }

        $batchSize = 500;
        $batches = array_chunk($rows, $batchSize);
        $totalImported = 0;

        foreach ($batches as $batch) {
            $records = [];
            foreach ($batch as $data) {
                if (empty($data) || !is_array($data)) continue;

                $department = trim($data[0] ?? '');
                $sampleType = trim($data[1] ?? '');
                $panel = trim($data[2] ?? '');
                $test = trim($data[3] ?? '');
                $code = trim($data[4] ?? '');
                $unit = trim($data[5] ?? '');
                $resultType = trim($data[6] ?? '');
                $normalRange = trim($data[7] ?? '');

                if (empty($code)) {
                    $code = 'LAB-' . strtoupper(substr(preg_replace('/\s+/', '', $department), 0, 3) . substr(preg_replace('/\s+/', '', $test), 0, 3) . rand(100, 999));
                }

                $records[] = [
                    'department' => $department,
                    'sample_type' => $sampleType,
                    'panel' => $panel,
                    'test' => $test,
                    'code' => $code,
                    'unit' => $unit,
                    'result_type' => $resultType,
                    'normal_range' => $normalRange,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($records)) {
                try {
                    LabTest::insert($records);
                    $totalImported += count($records);
                } catch (\Exception $e) {
                    foreach ($records as $record) {
                        try {
                            LabTest::create($record);
                            $totalImported++;
                        } catch (\Exception $e2) {
                            // Skip failed record
                        }
                    }
                }
            }
        }

        return redirect('/lab_tests')->with('success', "{$totalImported} lab tests imported successfully!");
    }

    public function template(): \Symfony\Component\HttpFoundation\StreamedResponse
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

    public function export(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $search = $request->input('search', '');
        $query = LabTest::query();

        if ($search) {
            $query->where('test', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
        }

        $tests = $query->orderBy('id', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="lab_tests_export.csv"',
        ];

        return response()->stream(function () use ($tests) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['department', 'sample_type', 'panel', 'test', 'code', 'unit', 'result_type', 'normal_range']);

            foreach ($tests as $test) {
                fputcsv($handle, [
                    $test->department,
                    $test->sample_type,
                    $test->panel,
                    $test->test,
                    $test->code,
                    $test->unit,
                    $test->result_type,
                    $test->normal_range,
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term', '');
        $tests = LabTest::where('test', 'like', "%{$term}%")
            ->orWhere('code', 'like', "%{$term}%")
            ->orWhere('department', 'like', "%{$term}%")
            ->limit(10)
            ->get(['id', 'test', 'code', 'department']);

        return response()->json([
            'success' => true,
            'data' => $tests
        ]);
    }

    public function show($id): View
    {
        $test = LabTest::findOrFail($id);
        return view('lab_tests.show', compact('test'));
    }
}
