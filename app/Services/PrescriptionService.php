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
            $patient = Patient::create([
                'patient_name' => $request->new_patient_name,
                'age' => $request->new_patient_age,
                'sex' => $request->new_patient_sex,
                'date' => $request->new_patient_date,
                'user_id' => $userId,
                'unique_id' => 'PAT-'.strtoupper(substr(md5(uniqid()), 0, 8)),
            ]);
            $patientId = $patient->id;
        } else {
            $patientId = $request->patient_id;
        }

        // Process medicines to include time and duration properly
        // Handle both JSON string and array input
        $medicinesInput = $request->medicines;
        if (is_string($medicinesInput)) {
            $medicinesInput = json_decode($medicinesInput, true);
        }
        $medicines = is_array($medicinesInput) ? $medicinesInput : [];
        
        $processedMedicines = [];
        foreach ($medicines as $med) {
            $processedMedicines[] = [
                'id' => $med['id'] ?? null,
                'name' => $med['name'] ?? '',
                'dosage' => $med['dosage'] ?? '',
                'time' => isset($med['time']) ? (is_string($med['time']) ? json_decode($med['time'], true) : $med['time']) : null,
                'duration' => isset($med['duration']) ? (is_string($med['duration']) ? json_decode($med['duration'], true) : $med['duration']) : null,
            ];
        }

        // Handle both JSON string and array input for problem and tests
        $problem = $request->problem;
        if (is_string($problem)) {
            $problem = json_decode($problem, true);
        }
        
        $tests = $request->tests;
        if (is_string($tests)) {
            $tests = json_decode($tests, true);
        }

        return Prescription::create([
            'user_id' => $userId,
            'patient_id' => $patientId,
            'doctor_id' => $doctorId,
            'problem' => $problem,
            'tests' => $tests,
            'medicines' => !empty($processedMedicines) ? $processedMedicines : null,
        ]);
    }

    public function updatePrescription(Request $request, Prescription $prescription): void
    {
        // Process medicines to include time and duration properly
        $medicinesInput = $request->medicines;
        if (is_string($medicinesInput)) {
            $medicinesInput = json_decode($medicinesInput, true);
        }
        $medicines = is_array($medicinesInput) ? $medicinesInput : [];
        
        $processedMedicines = [];
        foreach ($medicines as $med) {
            $processedMedicines[] = [
                'id' => $med['id'] ?? null,
                'name' => $med['name'] ?? '',
                'dosage' => $med['dosage'] ?? '',
                'time' => isset($med['time']) ? (is_string($med['time']) ? json_decode($med['time'], true) : $med['time']) : null,
                'duration' => isset($med['duration']) ? (is_string($med['duration']) ? json_decode($med['duration'], true) : $med['duration']) : null,
            ];
        }

        // Handle both JSON string and array input for problem and tests
        $problem = $request->problem;
        if (is_string($problem)) {
            $problem = json_decode($problem, true);
        }
        
        $tests = $request->tests;
        if (is_string($tests)) {
            $tests = json_decode($tests, true);
        }

        $prescription->update([
            'patient_id' => $request->patient_id ?? $prescription->patient_id,
            'doctor_id' => $request->doctor_id ?? $prescription->doctor_id,
            'problem' => $problem ?? $prescription->problem,
            'tests' => $tests ?? $prescription->tests,
            'medicines' => !empty($processedMedicines) ? $processedMedicines : $prescription->medicines,
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
