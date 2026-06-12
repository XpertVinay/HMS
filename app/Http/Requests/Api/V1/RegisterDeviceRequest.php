<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegisterDeviceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'device_uuid' => 'required|string|max:255',
            'fcm_token' => 'required|string|max:512',
            'os_type' => 'required|in:ios,android,web',
            'device_model' => 'nullable|string|max:100',
        ];
    }
}
