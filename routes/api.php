<?php

use App\Http\Controllers\Api\auth\GoogleController;
use App\Http\Controllers\Api\LogsController\PEELogControler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\auth\AuthController;
use App\Http\Controllers\Api\Auth\UserManagementController;

use App\Http\Controllers\Api\DashboardController;

use App\Http\Controllers\Api\LogsController\VehicleLogController;


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



Route::middleware(['auth:sanctum','role:admin'])->group(function () {

    Route::post('add/user', [UserManagementController::class, 'CreateUser']);
    Route::get('users', [UserManagementController::class, 'index']);
    Route::get('users/{user}', [UserManagementController::class, 'show']);
    Route::put('users/{user}', [UserManagementController::class, 'update']);
    Route::delete('users/{user}', [UserManagementController::class, 'destroy']);
});

Route::post('/vehicle-log', [VehicleLogController::class, 'storeVehicleLogAndNotify']);
Route::get('/vehicle-log/all', [VehicleLogController::class, 'index']);
Route::get('/vehicle-log/{id}', [VehicleLogController::class, 'show']);

Route::post('/pee-log', [PEELogControler::class, 'storePpeLogAndNotify']);
Route::get('/pee-log/all', [PEELogControler::class, 'index']);
Route::get('/pee-log/{id}', [PEELogControler::class, 'show']);

Route::get('/dashboard',[DashboardController::class,'index']);
