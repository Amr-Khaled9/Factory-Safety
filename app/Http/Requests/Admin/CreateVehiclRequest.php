<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateVehiclRequest extends FormRequest
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
            'authorized'     => 'required|boolean',
            'license_plate'  => 'required|string|min:7|max:10',
            'image'          => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'number_camera'  => 'required|integer|min:1',
            'vehicle_type' => 'required|string|in:car,bike,truck',
        ];
    }

    public function messages(): array
    {
        return [
            // authorized
            'authorized.required' => 'The authorized field is required.',
            'authorized.boolean'  => 'The authorized field must be true or false (0 or 1).',

            // license_plate
            'license_plate.required' => 'The license plate is required.',
            'license_plate.string'   => 'The license plate must be a valid string.',
            'license_plate.min'      => 'The license plate must be at least 7 characters.',
            'license_plate.max'      => 'The license plate may not be greater than 10 characters.',

            // image
            'image.required' => 'The image is required.',
            'image.image'    => 'The file must be a valid image.',
            'image.mimes'    => 'The image must be a file of type: jpg, jpeg, png.',
            'image.max'      => 'The image size must not exceed 2MB.',

            // number_camera
            'number_camera.required' => 'The camera number is required.',
            'number_camera.integer'  => 'The camera number must be an integer.',
            'number_camera.min'      => 'The camera number must be at least 1.',
        ];
    }
}
