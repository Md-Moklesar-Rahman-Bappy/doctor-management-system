<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
            'patient_name' => 'required|string|max:255',
            'age' => 'required|integer|min:0|max:150',
            'sex' => 'required|in:male,female',
            'date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_name.required' => 'Patient name is required.',
            'age.required' => 'Age is required.',
            'age.integer' => 'Age must be a number.',
            'age.min' => 'Age cannot be negative.',
            'age.max' => 'Age cannot exceed 150.',
            'sex.required' => 'Sex is required.',
            'sex.in' => 'Sex must be either male or female.',
            'date.required' => 'Date is required.',
            'date.date' => 'Please enter a valid date.',
        ];
    }
}
