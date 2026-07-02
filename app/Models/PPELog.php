<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PPELog extends Model
{

    protected $table = "ppe_logs";
    protected $fillable = [
        'image',
        'image_two',
        'violations',
        'camera_id',
        'worker_id',
        'person_id'
    ];

    protected $casts = [
        'violations' => 'array',
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

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->timezone('Africa/Cairo')
            ->format('Y-m-d H:i:s');
    }
    public function ppe()
    {
        return $this->belongsTo(PPE::class, 'ppe_id');
    }
}
