<?php

use App\Http\Controllers\ServicePageController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/services');
Route::get('/services', ServicePageController::class)->name('services.index');
