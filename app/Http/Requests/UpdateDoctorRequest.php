<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorRequest extends FormRequest
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
        $doctorId = $this->route('doctor');

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,'.$doctorId,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'degrees' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Doctor name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'phone.required' => 'Phone number is required.',
            'address.required' => 'Address is required.',
        ];
    }
}
