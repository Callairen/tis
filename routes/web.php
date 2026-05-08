<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', function() {
return response()->json(['message' => 'pong']);
});


// CRUD Student
Route::post('/students', [StudentController::class, 'store']);