<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\PartController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/auta');

Route::get('/auta', [CarController::class, 'index'])->name('cars');
Route::get('/diely', [PartController::class, 'index'])->name('parts');
