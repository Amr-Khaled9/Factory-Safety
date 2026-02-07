<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorizedVehicle extends Model
{
    protected $fillable = [
        'license_plate',
        'owner_name',
        'vehicle_type'
    ];
}
