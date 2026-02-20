<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehiclRequest extends FormRequest
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
            'authorized'     => 'sometimes|boolean',
            'license_plate'  => 'sometimes|string|min:7|max:10',
            'image'          => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
            'number_camera'  => 'sometimes|integer|min:1',
            'vehicle_type' => 'nullable|string|in:car,bike,truck',
        ];
    }
}
