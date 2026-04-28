<?php

namespace App\Http\Controllers;

use App\Models\LabTest;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Problem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrescriptionController extends Controller
{
    protected PrescriptionService $prescriptionService;

    public function __construct(PrescriptionService $prescriptionService)
    {
        $this->middleware('auth');
        $this->prescriptionService = $prescriptionService;
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

    public function store(StorePrescriptionRequest $request)
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        // If creating new patient inline
        if ($request->filled('new_patient_name')) {
            $patient = Patient::create($request->validated() + [
                'user_id' => auth()->id(),
                'unique_id' => 'PAT-'.strtoupper(substr(md5(uniqid()), 0, 8)),
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

        // Authorization check
        if ($prescription->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('prescriptions.show', compact('prescription'));
    }

    public function edit($id): View
    {
        $prescription = Prescription::with(['patient', 'doctor'])->findOrFail($id);

        // Authorization check
        if ($prescription->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        $doctor = $user->doctor;
        $problems = Problem::all();
        $labTests = LabTest::all();

        return view('prescriptions.edit', compact('prescription', 'doctor', 'problems', 'labTests'));
    }

    public function update(UpdatePrescriptionRequest $request, $id): RedirectResponse
    {
        $prescription = Prescription::findOrFail($id);

        // Authorization check
        if ($prescription->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
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

        // Authorization check
        if ($prescription->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

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
