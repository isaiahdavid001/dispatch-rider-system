<?php

use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'profile']);

use App\Http\Controllers\BookingController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/booking', [BookingController::class, 'create']);
    Route::post('/booking/{id}/accept', [BookingController::class, 'accept']);
    Route::post('/booking/{id}/complete', [BookingController::class, 'complete']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/ratings', [RatingController::class, 'store']); // Submit a rating
    Route::get('/ratings/{id}', [RatingController::class, 'show']); // Get ratings for a user or rider
});

