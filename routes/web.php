<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;

// Auth Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout']);

// API Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/api/user', [AuthController::class, 'user']);
    Route::post('/api/hotels', [HotelController::class, 'store']);
});

// Public API Routes
Route::get('/api/hotels', [HotelController::class, 'index']);

// Catch-all route for SPA (excludes telescope so it can serve its own UI)
Route::get('/', function () {
    return view('welcome');
});

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!telescope).*$');
