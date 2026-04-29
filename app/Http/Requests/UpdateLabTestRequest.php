<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLabTestRequest extends FormRequest
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
        $testId = $this->route('id');

        return [
            'department' => 'required|string|max:255',
            'sample_type' => 'required|string|max:255',
            'panel' => 'nullable|string|max:255',
            'test' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:lab_tests,code,'.$testId,
            'unit' => 'nullable|string|max:50',
            'result_type' => 'nullable|string|max:50',
            'normal_range' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'department.required' => 'Department is required.',
            'sample_type.required' => 'Sample type is required.',
            'test.required' => 'Test name is required.',
            'code.required' => 'Test code is required.',
            'code.unique' => 'This code is already in use.',
        ];
    }
}
