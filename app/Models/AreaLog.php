<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AreaLog extends Model
{
    protected $table = "area_logs";
    protected $fillable = [
        'image',
        'area_id',
        'camera_id',
        'worker_id'
    ];

        public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
