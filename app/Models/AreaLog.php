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

<<<<<<< HEAD
    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }


    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function camera()
    {
        return $this->belongsTo(Camera::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
=======
        public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
>>>>>>> fa6b5a2058f1b63a118f4e1abbee7ff61b3de0fa
}
