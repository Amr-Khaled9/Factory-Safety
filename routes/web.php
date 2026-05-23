<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\GateController;
use App\Http\Controllers\Web\PpeController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\UserManagementController;
use App\Http\Controllers\Web\VehicleManagementController;
use App\Http\Controllers\Web\VestController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:web')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('web.login');
});

Route::middleware('auth:web')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('web.logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');
    Route::get('/settings', function () {
        return view('settings.index', [
            'user' => auth()->user()
        ]);
    })->name('settings');

    Route::get('/ppe', [PpeController::class, 'index'])
        ->name('ppe.index');

    Route::get('/detections/{id}', [PpeController::class, 'show'])
        ->name('detections.show');

    Route::get('/gate', [GateController::class, 'index'])
        ->name('gate.index');

    Route::get('/gate/{id}', [GateController::class, 'show'])
        ->name('gate.show');
});

Route::middleware('admin')->group(function () {
    Route::resource('users', UserManagementController::class);

    Route::resource('vehicles', VehicleManagementController::class);

    Route::get(
        '/vehicles-authorized',
        [VehicleManagementController::class, 'authorized']
    )->name('vehicles.authorized');

    Route::get(
        '/vehicles-unauthorized',
        [VehicleManagementController::class, 'unauthorized']
    )->name('vehicles.unauthorized');
});
