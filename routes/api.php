<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('projects',ProjectController::class);
Route::resource('tasks', TaskController::class);

