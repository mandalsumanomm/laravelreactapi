<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Routes for User and Admin Login
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/admin/login', [AdminAuthController::class, 'login']); // Admin login

// General User Protected Routes (auth:sanctum)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

// Admin-Specific Protected Routes (auth:sanctum, isAPIAdmin)
Route::middleware(['auth:sanctum', 'isAPIAdmin'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/checkingAuthenticated', function () {
        return response()->json(['message' => 'You are in', 'status' => 200], 200);
    });

    // Admin Check
    Route::get('/admin/checkAuthenticated', function () {
        return response()->json(['status' => 200, 'message' => 'Admin authenticated'], 200);
    });
    
    // Store Product
    Route::post('/store-products', [ProductController::class, 'store']);
    Route::get('/view-products', [ProductController::class, 'index']);


    // Category Routes
    Route::post('/store-categories', [CategoryController::class, 'store']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']); // Add this route
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
});
