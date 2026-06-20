<?php

use App\Http\Controllers\Admin\VehiclManagementController;
use App\Http\Controllers\Api\auth\GoogleController;
use App\Http\Controllers\Api\LogsController\PPELogControler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\auth\AuthController;
use App\Http\Controllers\Api\auth\UserManagementController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\LogsController\FireLogController;
use App\Http\Controllers\Api\LogsController\SpeedViolationController;
use App\Http\Controllers\Api\LogsController\VehicleLogController;
use App\Http\Controllers\ReportController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::get('/v1/login', function () {
    return response()->json(['message' => 'Unauthenticated.'], 401);
})->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/report', [ReportController::class, 'getReport']);
});


Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::delete('users/{id}', [UserManagementController::class, 'destroy']);

    Route::post('add/user', [UserManagementController::class, 'CreateUser']);

    Route::get('users', [UserManagementController::class, 'index']);

    Route::get('users/{user}', [UserManagementController::class, 'show']);

    Route::put('users/{user}', [UserManagementController::class, 'update']);

    Route::get('/vehicles', [VehiclManagementController::class, 'index']);

    Route::post('/vehicles', [VehiclManagementController::class, 'create']);

    Route::put('/vehicles/{id}', [VehiclManagementController::class, 'update']);

    Route::delete('/vehicles/{id}', [VehiclManagementController::class, 'destroy']);

    Route::get('/vehicles/authorized', [VehiclManagementController::class, 'authorizedVehicles']);

    Route::get('/vehicles/unauthorized', [VehiclManagementController::class, 'unauthorizedVehicles']);
});


Route::get('/vehicle-log/all', [VehicleLogController::class, 'index']);
Route::get('/vehicle-log/{id}', [VehicleLogController::class, 'show']);


Route::get('/pee-log/all', [PPELogControler::class, 'index']);
Route::get('/pee-log/{id}', [PPELogControler::class, 'show']);

// Route::post('/speed-violations-log', [SpeedViolationController::class, 'storeSpeedViolationAndNotify']);
// Route::get('/speed-violations', [SpeedViolationController::class, 'index']);
// Route::get('/speed-violations/{id}', [SpeedViolationController::class, 'show']);

Route::get('/fire-logs', [FireLogController::class, 'index']);
Route::get('/fire-logs/{id}', [FireLogController::class, 'show']);



Route::middleware('ai.auth')->group(function () {
    Route::post('/pee-log', [PPELogControler::class, 'storePpeLogAndNotify']);
    Route::post('/vehicle-log', [VehicleLogController::class, 'storeVehicleLogAndNotify']);
    Route::post('/fire-log', [FireLogController::class, 'storeFireAndNotify']);
});
