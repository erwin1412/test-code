<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/customers', [CustomerController::class, 'index']);
Route::get('/customers/{customerCode}', [CustomerController::class, 'show']);

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{serviceCode}', [ServiceController::class, 'show']);
Route::patch('/services/{serviceCode}/status', [ServiceController::class, 'updateStatus']);
