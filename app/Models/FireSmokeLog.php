<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class FireSmokeLog extends Model
{
    protected $table = "fire_smoke_logs";
    protected $fillable = [
        'type',
        'image',
        'camera_id',
        'worker_id',
    ];

        public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
