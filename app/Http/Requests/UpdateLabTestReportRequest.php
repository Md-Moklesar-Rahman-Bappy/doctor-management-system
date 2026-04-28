<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLabTestReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $report = $this->route('lab_test_report');

        return $report && $report->patient && $report->patient->user_id === auth()->id();
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'sometimes|required|exists:patients,id',
            'test_name' => 'sometimes|required|string|max:255',
            'report_text' => 'nullable|string',
            'report_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Patient is required.',
            'patient_id.exists' => 'Selected patient does not exist.',
            'test_name.required' => 'Test name is required.',
            'report_images.*.image' => 'File must be an image.',
            'report_images.*.mimes' => 'Image must be JPEG, PNG, JPG, or GIF.',
            'report_images.*.max' => 'Image size cannot exceed 2MB.',
        ];
    }
}
