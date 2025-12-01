<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class MachineLog extends Model
{
    protected $table = "machine_logs";
    protected $fillable = [
        'image',
        'machine_id',
        'camera_id',
        'worker_id',
    ];

        public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
