<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'unit_number' => 'nullable|string|max:255',
            'street_area' => 'nullable|string|max:255',
            'locality_village' => 'nullable|string|max:255',
            'city_town' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:50',
            'type' => 'required|in:residential,commercial',
            'owner_id' => 'nullable|exists:member,id',
            'resident_id' => 'nullable|exists:resident,id',
            'unstructured_data' => 'nullable|string',
            
            // Allow staff-specific inputs to be validated and mapped in the service
            'property_number' => 'nullable|string|max:100',
            'block' => 'nullable|string|max:100',
            'building_name' => 'nullable|string|max:255',
        ];
    }
}
