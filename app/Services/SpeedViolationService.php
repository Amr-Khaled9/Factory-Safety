<?php

namespace App\Services;

use App\Models\SpeedViolation;
use App\Models\User;
use App\Traits\UploadImageTrait;

class SpeedViolationService
{
    use UploadImageTrait;
    public $fcmService;
    public function __construct(FcmService $fcmService)
    {
        $this->fcmService = $fcmService;
    }
    public function store($request)
    {
        $imageUrl = $this->uploadImage($request->file('image'));

        return SpeedViolation::create([
            'image' => $imageUrl,
            'car_speed' => $request->carSpeed
        ]);
    }
}
