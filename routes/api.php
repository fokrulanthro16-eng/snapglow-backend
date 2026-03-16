<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SwaggerTestController;
use App\Http\Controllers\Api\ToolHistoryController;

Route::get('/test', [SwaggerTestController::class, 'test']);

Route::get('/tool-histories', [ToolHistoryController::class, 'index']);
Route::post('/tool-histories', [ToolHistoryController::class, 'store']);
Route::get('/tool-histories/{id}', [ToolHistoryController::class, 'show']);
Route::delete('/tool-histories/{id}', [ToolHistoryController::class, 'destroy']);
