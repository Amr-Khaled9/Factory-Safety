<?php

use App\Http\Controllers\Api\auth\GoogleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/google/redirect', [GoogleController::class, 'redirect'])    ->middleware('web');
Route::get('/google/callback', [GoogleController::class, 'callback'])    ->middleware('web');


