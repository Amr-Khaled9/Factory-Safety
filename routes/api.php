<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// 1. Routes اللي مش محتاجة تسجيل دخول
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); // ده سيبيه زي ما هو
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// **الـ Route اللي بيحل مشكلة الـ 500 لازم يكون هنا (بره الـ Group)**
Route::get('/login', function () {
    return response()->json(['message' => 'Unauthenticated.'], 401);
})->name('login');

// 2. Routes اللي محتاجة تسجيل دخول
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
