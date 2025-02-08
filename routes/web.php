<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    dd(auth()->user());

    return ['Laravel' => app()->version()];
});
