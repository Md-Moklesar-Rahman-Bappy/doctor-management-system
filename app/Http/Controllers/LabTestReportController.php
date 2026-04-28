<?php

namespace App\Http\Controllers;

use App\Models\LabTestReport;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class LabTestReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 25);

        $query = LabTestReport::with('patient');

        if ($search) {
            $query->where('test_name', 'like', "%{$search}%")
                  ->orWhereHas('patient', function ($q) use ($search) {
                      $q->where('unique_id', 'like', "%{$search}%")
                        ->orWhere('patient_name', 'like', "%{$search}%");
                  });
        }

        $reports = $query->orderBy('id', 'desc')->paginate($perPage)->appends($request->except('page'));

        return view('lab_test_reports.index', compact('reports', 'search'));
    }

    public function create(Request $request): View
    {
        $patients = Patient::all();
        $selectedPatientId = $request->get('patient_id');

        return view('lab_test_reports.create', compact('patients', 'selectedPatientId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'test_name' => 'required|string|max:255',
            'report_text' => 'nullable|string',
            'report_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $report = LabTestReport::create([
            'patient_id' => $request->patient_id,
            'test_name' => $request->test_name,
            'report_text' => $request->report_text,
            'report_image' => null,
        ]);

        // Handle multiple image uploads
        if ($request->hasFile('report_images')) {
            $images = [];
            foreach ($request->file('report_images') as $image) {
                $path = $image->store('lab-reports/' . $report->id, 'public');
                $images[] = $path;
            }
            $report->update(['report_image' => json_encode($images)]);
        }

        return redirect('/lab-test-reports')->with('success', 'Lab test report created successfully!');
    }

    public function show($id): View
    {
        $report = LabTestReport::with('patient')->findOrFail($id);
        return view('lab_test_reports.show', compact('report'));
    }

    public function edit($id): View
    {
        $report = LabTestReport::findOrFail($id);
        $patients = Patient::all();

        return view('lab_test_reports.edit', compact('report', 'patients'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $report = LabTestReport::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'patient_id' => 'sometimes|required|exists:patients,id',
            'test_name' => 'sometimes|required|string|max:255',
            'report_text' => 'nullable|string',
            'report_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = [
            'test_name' => $request->test_name ?? $report->test_name,
            'report_text' => $request->report_text ?? $report->report_text,
        ];

        if ($request->hasFile('report_images')) {
            $images = [];
            foreach ($request->file('report_images') as $image) {
                $path = $image->store('lab-reports/' . $report->id, 'public');
                $images[] = $path;
            }
            $data['report_image'] = json_encode($images);
        }

        $report->update($data);

        return redirect('/lab-test-reports')->with('success', 'Lab test report updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        $report = LabTestReport::findOrFail($id);

        // Delete associated images
        if ($report->report_image) {
            $images = json_decode($report->report_image, true);
            if (is_array($images)) {
                foreach ($images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $report->delete();

        return redirect('/lab-test-reports')->with('success', 'Lab test report deleted successfully!');
    }
}
