<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register'])->name('user.register');
Route::post('/login', [UserController::class, 'login'])->name('user.login');
Route::middleware(['auth:sanctum'])->group(function() {
    Route::delete('/logout', [UserController::class, 'logout'])->name('user.logout');

    Route::apiResource('/sizes', SizeController::class);
    Route::apiResource('/categories', CategoryController::class);
    Route::apiResource('/colors', ColorController::class);
});
