<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientController extends Controller
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

        $query = Patient::query();

        if ($search) {
            $query->where('unique_id', 'like', "%{$search}%")
                ->orWhere('patient_name', 'like', "%{$search}%");
        }

        $patients = $query->orderBy($sortBy, $direction)->paginate($perPage)->appends($request->except('page'));

        return view('patients.index', compact('patients', 'search'));
    }

    public function create(): View
    {
        return view('patients.create');
    }

    public function store(StorePatientRequest $request): RedirectResponse
    {
        Patient::create($request->validated() + [
            'user_id' => auth()->id(),
            'unique_id' => 'PAT-'.strtoupper(substr(md5(uniqid()), 0, 8)),
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient created successfully!');
    }

    public function show($id): View
    {
        $patient = Patient::with('prescriptions', 'labTestReports')->findOrFail($id);

        // Authorization check - patients can view their own profile, doctors can view their patients
        if ($patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('patients.show', compact('patient'));
    }

    public function edit($id): View
    {
        $patient = Patient::findOrFail($id);

        // Authorization check
        if ($patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('patients.edit', compact('patient'));
    }

    public function update(UpdatePatientRequest $request, $id): RedirectResponse
    {
        $patient = Patient::findOrFail($id);

        // Authorization check
        if ($patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $patient->update($request->validated());

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        $patient = Patient::findOrFail($id);

        // Authorization check
        if ($patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully!');
    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('term', '');
        $patients = Patient::where('unique_id', 'like', "%{$term}%")
            ->orWhere('patient_name', 'like', "%{$term}%")
            ->limit(10)
            ->get();

        return response()->json(['success' => true, 'data' => $patients]);
    }

    public function getByUniqueId($uniqueId)
    {
        $patient = Patient::with('prescriptions', 'labTestReports')->where('unique_id', $uniqueId)->first();

        if (! $patient) {
            return response()->json(['success' => false, 'message' => 'Patient not found']);
        }

        return response()->json(['success' => true, 'data' => $patient]);
    }
}
