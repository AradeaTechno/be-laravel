<?php

use App\Http\Middleware\CustomSanctumMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware([CustomSanctumMiddleware::class])->group(function(){
    // USER
    Route::get('/users', [UserController::class, 'getAll'])->name('get_all_user');   
    Route::get('/users/{id}', [UserController::class, 'getById'])->name('get_user_by_id');   
    //POST
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'getById']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::patch('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'delete']);
    // WEATHER
    Route::get('/weather', [WeatherController::class, 'getCurrentWeather']);
});
