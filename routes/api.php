<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TouristController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public auth
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // Tourist routes
    Route::prefix('tourist')->middleware([\App\Http\Middleware\RoleMiddleware::class.':tourist'])->group(function () {
        Route::get('profile', [TouristController::class, 'profile']);
        Route::post('preferences', [TouristController::class, 'updatePreferences']);
        Route::get('bookings', [TouristController::class, 'bookings']);
        Route::get('notifications', [TouristController::class, 'notifications']);
        Route::get('my-bookings', [BookingController::class, 'myBookings']);
        Route::post('book', [BookingController::class, 'store']);
    });

    // Provider routes
    Route::prefix('provider')->middleware([\App\Http\Middleware\RoleMiddleware::class.':provider'])->group(function () {
        Route::get('profile', [ProviderController::class, 'profile']);
        Route::post('profile', [ProviderController::class, 'updateInfo']);
        Route::get('services', [ProviderController::class, 'services']);
        Route::get('comments', [ProviderController::class, 'comments']);
        Route::get('ratings', [ProviderController::class, 'ratings']);
        Route::post('services', [ServiceController::class, 'store']);
        Route::put('services/{service}', [ServiceController::class, 'update']);
        Route::delete('services/{service}', [ServiceController::class, 'destroy']);
    });

    // Notifications (admin + tourist)
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications', [NotificationController::class, 'createForTourist'])->middleware(\App\Http\Middleware\RoleMiddleware::class.':admin');

    // Admin-only
    Route::prefix('admin')->middleware([\App\Http\Middleware\RoleMiddleware::class.':admin'])->group(function () {
        Route::get('preferences', [AdminController::class, 'preferences']);
        Route::post('preferences/{preference}', [AdminController::class, 'updatePreference']);
        Route::get('pending-bookings', [AdminController::class, 'pendingBookings']);
        Route::get('stats', [AdminController::class, 'stats']);
    });
});
