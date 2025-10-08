<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware("auth:sanctum")->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::resource('tasks', TaskController::class);

    Route::post("logout", [AuthController::class, 'logout']);
});

