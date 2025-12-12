<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    public function camera(): BelongsTo
    {
        return $this->belongsTo(Camera::class, 'camera_id');
    }
    public function pees(): BelongsTo
    {
        return $this->belongsTo(PPE::class, 'ppe_id');
    }
    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }
    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
