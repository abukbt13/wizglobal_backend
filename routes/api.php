<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\StockPriceController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/stock-prices/upload', [StockPriceController::class, 'upload']);
    Route::get('/stock-prices/analysis', [StockPriceController::class, 'AnalyseStockPrices']);

    Route::get('/user', function (\Illuminate\Http\Request $request) {
        return $request->user();
    });
});
