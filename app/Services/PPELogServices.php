<?php

namespace App\Services;

use App\Models\Camera;
use App\Models\PPE;
use App\Models\PPELog;
use App\Models\User;
use App\Notifications\PEELogNotification;
use Cloudinary\Cloudinary;

class PPELogServices
{
    public function create($request, $imagePath, $imageTwoPath = null): PPELog
    {
        return PPELog::create([
            'image'      => $imagePath,
            'image_two'  => $imageTwoPath,
            'violations'     => json_encode($request->violations),
            'camera_id'  => Camera::where('number_camera', $request->number_camera)->value('id'),
            'person_id'  => $request->person_id,
            'worker_id'  => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function prepareForValidation()
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
}
