<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLabTestReportRequest;
use App\Http\Requests\UpdateLabTestReportRequest;
use App\Models\LabTestReport;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

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
        $sortBy = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');

        $query = LabTestReport::with('patient');

        if ($search) {
            $query->where('test_name', 'like', "%{$search}%")
                ->orWhereHas('patient', function ($q) use ($search) {
                    $q->where('unique_id', 'like', "%{$search}%")
                        ->orWhere('patient_name', 'like', "%{$search}%");
                });
        }

        $reports = $query->orderBy($sortBy, $direction)->paginate($perPage)->appends($request->except('page'));

        return view('lab_test_reports.index', compact('reports', 'search', 'sortBy', 'direction'));
    }

    public function create(Request $request): View
    {
        $patients = Patient::orderBy('patient_name')->paginate(50);
        $selectedPatientId = $request->get('patient_id');

        return view('lab_test_reports.create', compact('patients', 'selectedPatientId'));
    }

    public function store(StoreLabTestReportRequest $request): RedirectResponse
    {
        $report = LabTestReport::create($request->validated() + ['report_image' => null]);

        // Handle multiple image uploads
        if ($request->hasFile('report_images')) {
            $images = [];
            foreach ($request->file('report_images') as $image) {
                $path = $image->store('lab-reports/'.$report->id, 'public');
                $images[] = $path;
            }
            $report->update(['report_image' => json_encode($images)]);
        }

        return redirect()->route('lab_test_reports.index')->with('success', 'Lab test report created successfully!');
    }

    public function show($id): View
    {
        $report = LabTestReport::with('patient')->findOrFail($id);

        // Authorization check - user can only view reports for their patients
        if ($report->patient && $report->patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('lab_test_reports.show', compact('report'));
    }

    public function edit($id): View
    {
        $report = LabTestReport::with('patient')->findOrFail($id);

        // Authorization check
        if ($report->patient && $report->patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $patients = Patient::orderBy('patient_name')->paginate(50);

        return view('lab_test_reports.edit', compact('report', 'patients'));
    }

    public function update(UpdateLabTestReportRequest $request, $id): RedirectResponse
    {
        $report = LabTestReport::with('patient')->findOrFail($id);

        // Authorization check
        if ($report->patient && $report->patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validated();

        if ($request->hasFile('report_images')) {
            $images = [];
            foreach ($request->file('report_images') as $image) {
                $path = $image->store('lab-reports/'.$report->id, 'public');
                $images[] = $path;
            }
            $data['report_image'] = json_encode($images);
        }

        $report->update($data);

        return redirect()->route('lab_test_reports.index')->with('success', 'Lab test report updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        $report = LabTestReport::with('patient')->findOrFail($id);

        // Authorization check
        if ($report->patient && $report->patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

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

        return redirect()->route('lab_test_reports.index')->with('success', 'Lab test report deleted successfully!');
    }
}
