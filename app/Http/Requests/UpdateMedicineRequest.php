<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicineRequest extends FormRequest
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
        $medicineId = $this->route('medicine');

        return [
            'brand_name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'dosage_type' => 'required|string|max:50',
            'strength' => 'nullable|string|max:50',
            'company_name' => 'nullable|string|max:255',
            'package_mark' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'brand_name.required' => 'Brand name is required.',
            'dosage_type.required' => 'Dosage type is required.',
        ];
    }
}
