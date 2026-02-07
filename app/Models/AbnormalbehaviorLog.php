<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AbnormalbehaviorLog extends Model
{
    protected $table = "abnormalbehavior_logs";
    protected $fillable = [
        'behavior_type',
        'image',
        'camera_id',
        'worker_id',
    ];

        public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
