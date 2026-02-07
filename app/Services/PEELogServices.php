<?php

namespace App\Services;

use App\Models\Camera;
use App\Models\PPELog;
use App\Models\User;
use App\Notifications\PEELogNotification;
use Cloudinary\Cloudinary;

class PEELogServices
{
    public function upload($image): string
    {
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud.cloud_name'),
                'api_key'    => config('cloudinary.cloud.api_key'),
                'api_secret' => config('cloudinary.cloud.api_secret'),
            ],
        ]);

        $result = $cloudinary->uploadApi()->upload(
            $image->getRealPath(),
            ['folder' => 'laravel_uploads']
        );

        return $result['secure_url'];
    }

    public function create($request, $imagePath): PPELog
    {
        return PPELog::create([
            'image'      => $imagePath,
            'ppe_id'     => 1,
            'camera_id'  => Camera::where('number_camera', $request->number_camera)->value('id'),
            'worker_id'  => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function notifyAdmins(PPELog $peeLog, $notificationTitle, $notificationMessage): void
    {
        $admins = User::role('admin', 'api')->get();

        foreach ($admins as $admin) {
            $admin->notify(
                new PEELogNotification($notificationTitle, $notificationMessage, $peeLog)
            );
        }
    }
}
