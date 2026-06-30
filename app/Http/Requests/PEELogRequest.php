<?php

namespace App\Http\Requests;

use App\Models\PPE;
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

    protected function prepareForValidation()
    {
        if ($this->has('violations') && is_string($this->violations)) {
            $decoded = json_decode($this->violations, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $this->merge([
                    'violations' => $decoded,
                ]);
            }
        }
    }
    public function rules(): array
    {
        return [
            'violations' => 'required|array|min:1',
            'image' => 'required|image|max:2048',
            'number_camera' => 'required|integer',
            'person_id' => 'required|integer',
            'violations.*'  => 'required|string',



        ];
    }
    public function messages(): array
    {
        return [
            'violations.required' => 'Violations is required.',
            'type.string' => 'Type must be a string.',
            'type.in' => 'The type must be either veste or helmet.',

            'image.required' => 'Image is required.',
            'image.image' => 'File must be an image.',
            'image.max' => 'Image must not be larger than 2MB.',

            'number_camera.required' => 'Number of cameras is required.',
            'number_camera.integer' => 'Number of cameras must be an integer.',
            'person_id.required' => 'Person ID is required.',
            'person_id.integer' => 'Person ID must be an integer.',
        ];
    }
}
