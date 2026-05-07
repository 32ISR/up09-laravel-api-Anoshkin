<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function(){
Route::get('/bookings', [BookingController::class, 'index']);
Route::post('/booking', [BookingController::class, 'create']);
Route::get('/booking/{booking}', [BookingController::class, 'show']);
Route::patch('/booking/{booking}', [BookingController::class, 'update']);
Route::delete('/booking/{booking}', [BookingController::class, 'destroy']);
});