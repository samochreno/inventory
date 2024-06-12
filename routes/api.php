<?php

use App\Http\Controllers\Api\PartController;
use App\Http\Controllers\Api\CarController;
use Illuminate\Support\Facades\Route;

Route::prefix('cars')->group(function () {
    Route::get('/', [CarController::class, 'index']);
    Route::post('/', [CarController::class, 'create']);
    Route::put('/{car}', [CarController::class, 'update']);
    Route::delete('/{car}', [CarController::class, 'delete']);

    Route::get('/search', [CarController::class, 'search']);
});

Route::prefix('parts')->group(function () {
    Route::get('/', [PartController::class, 'index']);
    Route::post('/', [PartController::class, 'create']);
    Route::put('/{part}', [PartController::class, 'update']);
    Route::delete('/{part}', [PartController::class, 'delete']);
});
