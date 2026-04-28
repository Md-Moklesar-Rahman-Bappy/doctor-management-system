<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProblemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user() && auth()->user()->role === 'superadmin';
    }

    public function rules(): array
    {
        $problemId = $this->route('problem');

        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Problem name is required.',
            'name.max' => 'Problem name cannot exceed 255 characters.',
        ];
    }
}
