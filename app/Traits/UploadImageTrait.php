<?php

namespace App\Traits;

use Cloudinary\Cloudinary;

trait UploadImageTrait
{
    public function uploadImage($image): string
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
}
