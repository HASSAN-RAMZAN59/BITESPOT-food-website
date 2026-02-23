<?php

use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RestaurantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Restaurant routes
Route::prefix('restaurants')->group(function () {
    Route::get('/', [RestaurantController::class, 'index']);
    Route::get('/{id}', [RestaurantController::class, 'show']);
    Route::get('/{id}/menu', [RestaurantController::class, 'menu']);
});

// Menu items routes
Route::prefix('menu-items')->group(function () {
    Route::get('/', [MenuItemController::class, 'index']);
    Route::get('/{id}', [MenuItemController::class, 'show']);
});

// Order routes
Route::prefix('orders')->group(function () {
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/{id}', [OrderController::class, 'show']);
    Route::get('/track/{orderNumber}', [OrderController::class, 'track']);
    Route::patch('/{id}/status', [OrderController::class, 'updateStatus']);
});

// Health check route
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toIso8601String()
    ]);
});
