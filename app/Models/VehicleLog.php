<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class VehicleLog extends Model
{
    protected $fillable = [
        'license_plate',
        'image',
        'authorized',
        'vehicle_id',
        'camera_id'
    ];



    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
