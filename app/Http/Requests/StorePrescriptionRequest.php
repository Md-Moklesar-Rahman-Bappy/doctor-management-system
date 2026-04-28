<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrescriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required_without:new_patient_name|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'problem' => 'nullable|array',
            'tests' => 'nullable|array',
            'medicines' => 'nullable|array',
            'new_patient_name' => 'required_without:patient_id|string|max:255',
            'new_patient_age' => 'required_with:new_patient_name|integer|min:0|max:150',
            'new_patient_sex' => 'required_with:new_patient_name|in:male,female',
            'new_patient_date' => 'required_with:new_patient_name|date',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required_without' => 'Patient is required.',
            'doctor_id.required' => 'Doctor is required.',
            'new_patient_name.required_without' => 'Patient name is required.',
            'new_patient_age.required_with' => 'Age is required.',
            'new_patient_sex.required_with' => 'Sex is required.',
            'new_patient_date.required_with' => 'Date is required.',
        ];
    }
}
