<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PEELogRequest extends FormRequest
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
            'type' => 'required|string|in:veste,helmet',
            'image' => 'required|image|max:2048',
            'number_camera' => 'required|integer'
        ];
    }
    public function messages(): array
    {
        return [
            'type.required' => 'Type is required.',
            'type.string' => 'Type must be a string.',
            'type.in' => 'The type must be either veste or helmet.',

            'image.required' => 'Image is required.',
            'image.image' => 'File must be an image.',
            'image.max' => 'Image must not be larger than 2MB.',

            'number_camera.required' => 'Number of cameras is required.',
            'number_camera.integer' => 'Number of cameras must be an integer.',
        ];
    }
}
