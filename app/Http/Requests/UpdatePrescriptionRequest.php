<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrescriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $prescription = $this->route('prescription');

        return $prescription && $prescription->user_id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'sometimes|required|exists:patients,id',
            'doctor_id' => 'sometimes|required|exists:doctors,id',
            'problem' => 'nullable|array',
            'tests' => 'nullable|array',
            'medicines' => 'nullable|array',
        ];
    }
}
