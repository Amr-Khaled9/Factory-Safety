<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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


    public function camera() : BelongsTo {
        return $this->belongsTo(Camera::class , 'camera_id');
    }
    public function vehicle() : BelongsTo {
        return $this->belongsTo(Vehicle::class , 'vehicle_id');
    }
    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
