<?php

namespace App\Services;

use App\Models\FireLog;
use App\Traits\UploadImageTrait;

class FireLogService
{
    use UploadImageTrait;

    public function store($request)
    {
        $imageUrl = null;

        if ($request->hasFile('image')) {
            $imageUrl = $this->uploadLocal($request->file('image'), 'fire');
        }

        return FireLog::create([
            'type' => $request->type,
            'confidence' => $request->confidence,
            'image' => $imageUrl,
            'number_camera' => $request->number_camera
        ]);
    }
}
