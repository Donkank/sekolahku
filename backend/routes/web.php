<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/symlink', function () {
    Artisan::call('storage:link');
    return response()->json('Symlink success', 200);
});

Route::get('/', function () {
    return response()->json(['SD NO. 1 KEKERAN' => app()->version()], 200);
});
