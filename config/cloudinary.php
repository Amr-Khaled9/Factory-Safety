<?php

/*
 * This file is part of the Laravel Cloudinary package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
return [
    'cloud_url' => env('CLOUDINARY_URL', 'cloudinary://' . env('CLOUDINARY_KEY') . ':' . env('CLOUDINARY_SECRET') . '@' . env('CLOUDINARY_CLOUD_NAME')),
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),
    'upload_route' => env('CLOUDINARY_UPLOAD_ROUTE'),
    'upload_action' => env('CLOUDINARY_UPLOAD_ACTION'),
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),
    'cloud' => [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
        'api_key'    => env('CLOUDINARY_KEY'),
        'api_secret' => env('CLOUDINARY_SECRET'),
    ],
];
