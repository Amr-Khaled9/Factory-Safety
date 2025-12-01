<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = "vehicles";

    protected $fillable = [
        'license_plate',
        'authorized',
        'vehicle_type',
        'image'
    ];
}
