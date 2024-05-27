<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MessageController::class, 'showForm']);

Route::post('/', [MessageController::class, 'validateForm']);

Route::get('/message/{token}', [MessageController::class, 'showMessage']);
