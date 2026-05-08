<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Api\AuthController;

Route::get('/status', function () {
    return response()->json([
        "app" => "Todo API",
        "status" => "running"
    ]);
});

Route::get('/greet/{name}', function ($name) {
    return response()->json([
        "message" => "Hello, $name!"
    ]);
});

Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('/students/{nim}', [StudentController::class, 'show']);
Route::put('/students/{nim}', [StudentController::class, 'update']);
Route::patch('/students/{nim}', [StudentController::class, 'update']);
Route::delete('/students/{nim}', [StudentController::class, 'destroy']);
Route::get('/students/{nim}/mata-kuliah', [StudentController::class, 'matakuliahByStudent']);

// Route yang bisa diakses publik (tanpa token) [cite: 202-203]
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route yang diproteksi oleh middleware JWT kustom [cite: 204-207, 226-228]
Route::middleware(['dummy.jwt'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/token-check', [AuthController::class, 'tokenCheck']);
});