<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPE extends Model
{
    protected $table = "ppes";
    protected $fillable = [
        'ppe_type',
        'description'
    ];
}
