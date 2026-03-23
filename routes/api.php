<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\Api\MobileApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Legacy auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');

// Legacy property routes
Route::get('properties', [PropertyController::class, 'index']);
Route::get('properties/{property}', [PropertyController::class, 'show']); // Public access
Route::post('properties', [PropertyController::class, 'store'])->middleware('auth:sanctum');
Route::put('properties/{property}', [PropertyController::class, 'update'])->middleware('auth:sanctum');
Route::delete('properties/{property}', [PropertyController::class, 'destroy'])->middleware('auth:sanctum');

/**
 * Mobile API Routes - v1
 * 
 * Base URL: /api/v1
 * All requests require Bearer token authentication
 * Supports: iOS, Android, React Native, Flutter apps
 */

Route::middleware(['api', 'auth:sanctum'])->prefix('v1')->group(function () {
    
    // Auth & Profile endpoints
    Route::prefix('auth')->group(function () {
        Route::get('/profile', [MobileApiController::class, 'getProfile']);
        Route::put('/profile', [MobileApiController::class, 'updateProfile']);
        Route::post('/logout', function() {
            Auth::user()->tokens()->delete();
            return response()->json(['success' => true, 'message' => 'Logged out']);
        });
    });

    // Properties endpoints
    Route::prefix('properties')->group(function () {
        Route::get('/', [MobileApiController::class, 'getProperties']);
        Route::get('/search', [MobileApiController::class, 'searchProperties']);
        Route::get('/{id}', [MobileApiController::class, 'getProperty']);
        Route::post('/', [MobileApiController::class, 'createProperty']);
    });

    // Bookings endpoints
    Route::prefix('bookings')->group(function () {
        Route::get('/', [MobileApiController::class, 'getBookings']);
        Route::get('/{id}', [MobileApiController::class, 'getBooking']);
        Route::post('/', [MobileApiController::class, 'createBooking']);
    });

    // Reviews endpoints
    Route::prefix('reviews')->group(function () {
        Route::get('/', [MobileApiController::class, 'getReviews']);
        Route::post('/', [MobileApiController::class, 'createReview']);
    });

    // Notifications endpoints
    Route::prefix('notifications')->group(function () {
        Route::get('/', [MobileApiController::class, 'getNotifications']);
        Route::put('/{id}/read', [MobileApiController::class, 'markNotificationRead']);
    });

    // Wallet endpoints
    Route::prefix('wallet')->group(function () {
        Route::get('/', [MobileApiController::class, 'getWallet']);
    });

});

// Public endpoints (no auth required)
Route::middleware('api')->prefix('v1')->group(function () {
    
    Route::get('/health', [MobileApiController::class, 'health']);

    // Public property search
    Route::get('/properties/search', [MobileApiController::class, 'searchProperties']);

    // Property details (public)
    Route::get('/properties/{id}', function($id) {
        return response()->json([
            'success' => true,
            'property' => \App\Models\Property::findOrFail($id)->load('reviews', 'amenities')
        ]);
    });

    // Property reviews (public)
    Route::get('/properties/{id}/reviews', function($id) {
        $reviews = \App\Models\Review::where('reviewee_id', 
            \App\Models\Property::findOrFail($id)->host_id
        )->paginate(20);

        return response()->json([
            'success' => true,
            'reviews' => $reviews
        ]);
    });

});