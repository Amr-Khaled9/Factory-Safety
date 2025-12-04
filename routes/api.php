<?php

use App\Http\Controllers\Api\auth\GoogleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\auth\AuthController;
use App\Http\Controllers\Api\auth\UserManagementController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::get('/login', function () {
    return response()->json(['message' => 'Unauthenticated.'], 401);
})->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});



Route::get('/google/redirect', [GoogleController::class, 'redirect'])->middleware('web');
Route::get('/google/callback', [GoogleController::class, 'callback'])->middleware('web');



Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('good', function () {
        return true;
    }); //test Role
    Route::post('add/user',[UserManagementController::class, 'CreateUser']);
});
