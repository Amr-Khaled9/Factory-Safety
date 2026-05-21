<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ReportController;
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
});
