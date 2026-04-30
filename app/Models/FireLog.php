<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FireLog extends Model
{
    protected $fillable = [
        'type',
        'confidence',
        'image',
        'number_camera'
    ];
}
