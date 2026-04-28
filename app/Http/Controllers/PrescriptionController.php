<?php

namespace App\Http\Controllers;

use App\Models\LabTest;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Problem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PrescriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 25);

        $query = Prescription::with(['patient', 'doctor']);

        if ($search) {
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('unique_id', 'like', "%{$search}%")
                    ->orWhere('patient_name', 'like', "%{$search}%");
            });
        }

        $prescriptions = $query->orderBy('id', 'desc')->paginate($perPage)->appends($request->except('page'));

        return view('prescriptions.index', compact('prescriptions', 'search'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        if (! $doctor) {
            return redirect('/doctors/create')->with('error', 'Please create your doctor profile first.');
        }

        $problems = Problem::all();
        $labTests = LabTest::all();

        // If patient_id is passed from patient profile
        $selectedPatientId = $request->get('patient_id');

        return view('prescriptions.create', compact('doctor', 'problems', 'labTests', 'selectedPatientId'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        $validator = Validator::make($request->all(), [
            'patient_id' => 'required_without:new_patient_name|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'problem' => 'nullable|array',
            'tests' => 'nullable|array',
            'medicines' => 'nullable|array',
            'new_patient_name' => 'required_without:patient_id|string|max:255',
            'new_patient_age' => 'required_with:new_patient_name|integer|min:0|max:150',
            'new_patient_sex' => 'required_with:new_patient_name|in:male,female',
            'new_patient_date' => 'required_with:new_patient_name|date',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $validator->errors()]);
            }

            return back()->withErrors($validator)->withInput();
        }

        // If creating new patient inline
        if ($request->filled('new_patient_name')) {
            $patient = Patient::create([
                'user_id' => auth()->id(),
                'unique_id' => 'PAT-'.strtoupper(substr(md5(uniqid()), 0, 8)),
                'patient_name' => $request->new_patient_name,
                'age' => $request->new_patient_age,
                'sex' => $request->new_patient_sex,
                'date' => $request->new_patient_date,
            ]);
            $patientId = $patient->id;
        } else {
            $patientId = $request->patient_id;
        }

        $prescription = Prescription::create([
            'user_id' => auth()->id(),
            'patient_id' => $patientId,
            'doctor_id' => $doctor ? $doctor->id : $request->doctor_id,
            'problem' => $request->problem ? json_encode($request->problem) : null,
            'tests' => $request->tests ? json_encode($request->tests) : null,
            'medicines' => $request->medicines ? json_encode($request->medicines) : null,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'prescription_id' => $prescription->id]);
        }

        return redirect('/prescriptions')->with('success', 'Prescription created successfully!');
    }

    public function show($id): View
    {
        $prescription = Prescription::with(['patient', 'doctor'])->findOrFail($id);

        return view('prescriptions.show', compact('prescription'));
    }

    public function edit($id): View
    {
        $prescription = Prescription::with(['patient', 'doctor'])->findOrFail($id);
        $user = auth()->user();
        $doctor = $user->doctor;
        $problems = Problem::all();
        $labTests = LabTest::all();

        return view('prescriptions.edit', compact('prescription', 'doctor', 'problems', 'labTests'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $prescription = Prescription::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'patient_id' => 'sometimes|required|exists:patients,id',
            'doctor_id' => 'sometimes|required|exists:doctors,id',
            'problem' => 'nullable|array',
            'tests' => 'nullable|array',
            'medicines' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $prescription->update([
            'patient_id' => $request->patient_id ?? $prescription->patient_id,
            'doctor_id' => $request->doctor_id ?? $prescription->doctor_id,
            'problem' => $request->problem ? json_encode($request->problem) : $prescription->problem,
            'tests' => $request->tests ? json_encode($request->tests) : $prescription->tests,
            'medicines' => $request->medicines ? json_encode($request->medicines) : $prescription->medicines,
        ]);

        return redirect('/prescriptions')->with('success', 'Prescription updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->delete();

        return redirect('/prescriptions')->with('success', 'Prescription deleted successfully!');
    }

    public function getPatientPrescriptions($patientId)
    {
        $prescriptions = Prescription::with(['doctor'])
            ->where('patient_id', $patientId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $prescriptions]);
    }
}
