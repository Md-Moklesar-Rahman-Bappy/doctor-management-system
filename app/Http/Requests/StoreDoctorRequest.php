<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'license' => 'required|string|unique:doctors,license',
            'email' => 'required|email|unique:doctors,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'degrees' => 'nullable|array',
            'degrees.*' => 'string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Doctor name is required.',
            'name.max' => 'Doctor name cannot exceed 255 characters.',
            'license.required' => 'License number is required.',
            'license.unique' => 'This license number is already registered.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'phone.required' => 'Phone number is required.',
            'phone.max' => 'Phone number cannot exceed 20 characters.',
            'address.required' => 'Address is required.',
            'address.max' => 'Address cannot exceed 500 characters.',
            'degrees.*.string' => 'Each degree must be a valid string.',
            'degrees.*.max' => 'Each degree cannot exceed 255 characters.',
        ];
    }
}
