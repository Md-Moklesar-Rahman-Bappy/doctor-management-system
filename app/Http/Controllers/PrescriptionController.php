<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrescriptionRequest;
use App\Http\Requests\UpdatePrescriptionRequest;
use App\Models\LabTest;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Problem;
use App\Services\PrescriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $sortBy = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');

        $query = Prescription::with(['patient', 'doctor']);

        if ($search) {
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('unique_id', 'like', "%{$search}%")
                    ->orWhere('patient_name', 'like', "%{$search}%");
            });
        }

        $prescriptions = $query->orderBy($sortBy, $direction)->paginate($perPage)->appends($request->except('page'));

        return view('prescriptions.index', compact('prescriptions', 'search', 'sortBy', 'direction'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        $user = auth()->user();
        $doctor = $user->doctor;

        if (! $doctor) {
            return redirect()->route('doctors.create')->with('error', 'Please create your doctor profile first.');
        }

        $problems = Problem::orderBy('name')->paginate(50);
        $labTests = LabTest::orderBy('test')->paginate(50);

        // If patient_id is passed from patient profile
        $selectedPatientId = $request->get('patient_id');

        return view('prescriptions.create', compact('doctor', 'problems', 'labTests', 'selectedPatientId'));
    }

    public function store(StorePrescriptionRequest $request)
    {
        try {
            $doctor = auth()->user()->doctor ?? null;
            $doctorId = $doctor ? $doctor->id : $request->doctor_id;
            
            \Log::info('Prescription store attempt', [
                'doctor_id' => $doctorId,
                'patient_id' => $request->patient_id,
                'has_new_patient' => $request->filled('new_patient_name'),
                'user_id' => auth()->user()->id
            ]);

            $prescription = $this->prescriptionService->createPrescription($request, $doctorId);

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'prescription_id' => $prescription->id]);
            }

            return redirect()->route('prescriptions.index')->with('success', 'Prescription created successfully!');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }

            return back()->with('error', 'Error creating prescription: ' . $e->getMessage());
        }
    }

    public function show($id): View
    {
        $prescription = Prescription::with(['patient', 'doctor'])->findOrFail($id);
        $user = auth()->user();

        // Authorization check - user must be the doctor or the patient's owner
        $isDoctor = $prescription->doctor && $prescription->doctor->user_id === $user->id;
        $isPatientOwner = $prescription->patient && $prescription->patient->user_id === $user->id;

        if (!$isDoctor && !$isPatientOwner && !$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return view('prescriptions.show', compact('prescription'));
    }

    public function edit($id): View
    {
        $prescription = Prescription::with(['patient', 'doctor'])->findOrFail($id);
        $user = auth()->user();

        // Authorization check - user must be the doctor or admin
        $isDoctor = $prescription->doctor && $prescription->doctor->user_id === $user->id;

        if (!$isDoctor && !$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $doctor = $user->doctor;
        $problems = Problem::orderBy('name')->paginate(50);
        $labTests = LabTest::orderBy('test')->paginate(50);

        return view('prescriptions.edit', compact('prescription', 'doctor', 'problems', 'labTests'));
    }

    public function update(UpdatePrescriptionRequest $request, $id): RedirectResponse
    {
        $prescription = Prescription::findOrFail($id);
        $user = auth()->user();

        // Authorization check - user must be the doctor or admin
        $isDoctor = $prescription->doctor && $prescription->doctor->user_id === $user->id;

        if (!$isDoctor && !$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $this->prescriptionService->updatePrescription($request, $prescription);

        return redirect()->route('prescriptions.index')->with('success', 'Prescription updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        $prescription = Prescription::findOrFail($id);
        $user = auth()->user();

        // Authorization check - user must be the doctor or admin
        $isDoctor = $prescription->doctor && $prescription->doctor->user_id === $user->id;

        if (!$isDoctor && !$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $prescription->delete();

        return redirect()->route('prescriptions.index')->with('success', 'Prescription deleted successfully!');
    }

    public function downloadPdf($id)
    {
        $prescription = Prescription::with(['patient', 'doctor'])->findOrFail($id);
        $user = auth()->user();

        // Authorization check - user must be the doctor or the patient's owner
        $isDoctor = $prescription->doctor && $prescription->doctor->user_id === $user->id;
        $isPatientOwner = $prescription->patient && $prescription->patient->user_id === $user->id;

        if (!$isDoctor && !$isPatientOwner && !$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $pdf = Pdf::loadView('prescriptions.pdf', compact('prescription'))
            ->setPaper('a4', 'portrait');

        $fileName = 'prescription_' . ($prescription->patient->patient_name ?? 'patient') . '_' . $prescription->created_at->format('Y-m-d') . '.pdf';

        return $pdf->download($fileName);
    }

    public function getPatientPrescriptions($patientId)
    {
        $prescriptions = $this->prescriptionService->getPatientPrescriptions($patientId);

        return response()->json(['success' => true, 'data' => $prescriptions]);
    }
}
