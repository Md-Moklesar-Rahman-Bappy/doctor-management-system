<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

        $query = Patient::query();

        if ($search) {
            $query->where('unique_id', 'like', "%{$search}%")
                ->orWhere('patient_name', 'like', "%{$search}%");
        }

        $patients = $query->orderBy('id', 'desc')->paginate($perPage)->appends($request->except('page'));

        return view('patients.index', compact('patients', 'search'));
    }

    public function create(): View
    {
        return view('patients.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'patient_name' => 'required|string|max:255',
            'age' => 'required|integer|min:0|max:150',
            'sex' => 'required|in:male,female',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Patient::create([
            'user_id' => auth()->id(),
            'unique_id' => 'PAT-'.strtoupper(substr(md5(uniqid()), 0, 8)),
            'patient_name' => $request->patient_name,
            'age' => $request->age,
            'sex' => $request->sex,
            'date' => $request->date,
        ]);

        return redirect('/patients')->with('success', 'Patient created successfully!');
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

    public function update(Request $request, $id): RedirectResponse
    {
        $patient = Patient::findOrFail($id);

        // Authorization check
        if ($patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'patient_name' => 'required|string|max:255',
            'age' => 'required|integer|min:0|max:150',
            'sex' => 'required|in:male,female',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $patient->update([
            'patient_name' => $request->patient_name,
            'age' => $request->age,
            'sex' => $request->sex,
            'date' => $request->date,
        ]);

        return redirect('/patients')->with('success', 'Patient updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        $patient = Patient::findOrFail($id);

        // Authorization check
        if ($patient->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $patient->delete();

        return redirect('/patients')->with('success', 'Patient deleted successfully!');
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
