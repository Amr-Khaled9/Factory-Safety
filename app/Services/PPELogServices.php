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
    public function create($request, $imagePath): PPELog
    {
        $type = PPE::where('ppe_type', $request->type)->first();
        return PPELog::create([
            'image'      => $imagePath,
            'ppe_id'     => $type->id,
            'camera_id'  => Camera::where('number_camera', $request->number_camera)->value('id'),
            'worker_id'  => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
