<?php

use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(\App\Http\Controllers\Api\AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('education', EducationController::class);
    Route::get('/profile/{id}', [UserController::class, 'profile']);
    Route::get('/quiz', [QuizController::class, 'index']);
});
