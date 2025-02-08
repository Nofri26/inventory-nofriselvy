<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::post('/register', [Controllers\UserController::class, 'register'])->name('user.register');
Route::post('/login', [Controllers\UserController::class, 'login'])->name('user.login');
Route::middleware(['auth:sanctum'])->group(function() {
    Route::delete('/logout', [Controllers\UserController::class, 'logout'])->name('user.logout');

    Route::get('/sizes/get', [Controllers\SizeController::class, 'get'])->name('sizes.get');
    Route::apiResource('/sizes', Controllers\SizeController::class);

    Route::get('/categories/get', [Controllers\CategoryController::class, 'get'])->name('categories.get');
    Route::apiResource('/categories', Controllers\CategoryController::class);

    Route::get('/colors/get', [Controllers\ColorController::class, 'get'])->name('colors.get');
    Route::apiResource('/colors', Controllers\ColorController::class);

    Route::apiResource('/products', Controllers\ProductController::class);
});
