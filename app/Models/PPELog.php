<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PPELog extends Model
{
    //
    protected $table = "ppe_logs";
    protected $fillable = [
        'image',
        'ppe_id',
        'camera_id',
        'worker_id'
    ];

        public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
