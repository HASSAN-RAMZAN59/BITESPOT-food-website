<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'BiteSpot API',
        'version' => '1.0',
        'status' => 'active'
    ]);
});
