<?php

use App\Http\Controllers\Api\HospitalApiController;
use App\Http\Controllers\Api\PatientApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\AllApiController;
use App\Http\Controllers\Api\ResourceApiController;
use Illuminate\Support\Facades\Route;

// Resource API - All models CRUD with model in path
Route::get('/Resources/{Model}', [ResourceApiController::class, 'Show']);
Route::post('/Resources/{Model}', [ResourceApiController::class, 'Store']);
Route::put('/Resources/{Model}/{Id}', [ResourceApiController::class, 'Update']);
Route::delete('/Resources/{Model}/{Id}', [ResourceApiController::class, 'Destroy']);
