<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function(){
  Route::get('/profile', [AuthController::class, 'profile']);
  Route::post('/logout', [AuthController::class, 'logout']);

  Route::get('/students', [StudentController::class, 'index']);
  Route::post('/students', [StudentController::class,'store']);
  Route::get('/students/{id}', [StudentController::class, 'show']);
  Route::put('/students/{id}', [StudentController::class, 'update']);
  Route::delete('/students/{id}', [StudentController::class, 'destroy']);

  Route::get('/teachers', [TeacherController::class, 'index']);
  Route::post('/teachers', [TeacherController::class,'store']);
  Route::get('/teachers/{id}', [TeacherController::class, 'show']);
  Route::put('/teachers/{id}', [TeacherController::class, 'update']);
  Route::delete('/teachers/{id}', [TeacherController::class, 'destroy']);
});