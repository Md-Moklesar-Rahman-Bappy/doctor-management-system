<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionService
{
    public function createPrescription(Request $request, $doctorId): Prescription
    {
        $userId = auth()->user()->id ?? null;

        // If creating new patient inline
        if ($request->filled('new_patient_name')) {
            $patient = Patient::create($request->validated() + [
                'user_id' => $userId,
                'unique_id' => 'PAT-'.strtoupper(substr(md5(uniqid()), 0, 8)),
            ]);
            $patientId = $patient->id;
        } else {
            $patientId = $request->patient_id;
        }

        return Prescription::create([
            'user_id' => $userId,
            'patient_id' => $patientId,
            'doctor_id' => $doctorId,
            'problem' => $request->problem ? json_encode($request->problem) : null,
            'tests' => $request->tests ? json_encode($request->tests) : null,
            'medicines' => $request->medicines ? json_encode($request->medicines) : null,
        ]);
    }

    public function updatePrescription(Request $request, Prescription $prescription): void
    {
        $prescription->update([
            'patient_id' => $request->patient_id ?? $prescription->patient_id,
            'doctor_id' => $request->doctor_id ?? $prescription->doctor_id,
            'problem' => $request->problem ? json_encode($request->problem) : $prescription->problem,
            'tests' => $request->tests ? json_encode($request->tests) : $prescription->tests,
            'medicines' => $request->medicines ? json_encode($request->medicines) : $prescription->medicines,
        ]);
    }

    public function getPatientPrescriptions($patientId)
    {
        return Prescription::with(['doctor'])
            ->where('patient_id', $patientId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
