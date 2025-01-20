<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProjectController::class, 'index']);

Route::resource('projects', ProjectController::class);

Route::post('projects/{project}/startTiming', [ProjectController::class, 'startTiming'])->name('projects.startTiming');
Route::post('projects/{project}/stopTiming', [ProjectController::class, 'stopTiming'])->name('projects.stopTiming');



