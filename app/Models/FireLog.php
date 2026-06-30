<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class FireLog extends Model
{
    protected $fillable = [
        'type',
        'confidence',
        'image',
        'number_camera'
    ];

    public function camera()
    {
        return $this->belongsTo(Camera::class, 'camera_id');
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->timezone('Africa/Cairo')
            ->format('Y-m-d H:i:s');
    }
}
