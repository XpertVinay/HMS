<?php

use App\Http\Controllers\Api\ThemeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Theme Engine API routes.
| These are stateless, public endpoints for theme data consumption.
|
*/

Route::prefix('api/theme')->name('api.theme.')->group(function () {
    Route::get('/resolve', [ThemeController::class, 'resolve'])->name('resolve');
    Route::get('/presets', [ThemeController::class, 'presets'])->name('presets');
    Route::get('/{orgId}', [ThemeController::class, 'show'])->name('show');
    Route::get('/{orgId}/css', [ThemeController::class, 'css'])->name('css');
});

Route::prefix('api/auth')->name('api.auth.')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');
});

/*
|--------------------------------------------------------------------------
| Mobile V1 APIs
|--------------------------------------------------------------------------
*/
Route::prefix('api/v1')->name('api.v1.')->middleware('throttle:api')->group(function () {
    // V1 Auth
    Route::prefix('auth')->name('auth.')->group(function () {
        // We will move login to v1 later or keep backward compatibility
        Route::post('/login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login'])->name('login');
        
        Route::middleware('auth:api_member,api_resident,api_staff,api_vendor')->group(function() {
            Route::post('/logout', [\App\Http\Controllers\Api\V1\AuthController::class, 'logout'])->name('logout');
            Route::get('/profile', [\App\Http\Controllers\Api\V1\AuthController::class, 'profile'])->name('profile');
        });
    });

    // Member & Resident APIs
    Route::prefix('member')->name('member.')->middleware('auth:api_member,api_resident')->group(function () {
        // Tickets/Helpdesk
        // Bills/Maintenance
        // Community
        // Solid Approvals
    });

    // Staff APIs
    Route::prefix('staff')->name('staff.')->middleware('auth:api_staff')->group(function () {
        
    });

    // Vendor APIs
    Route::prefix('vendor')->name('vendor.')->middleware('auth:api_vendor')->group(function () {
        
    });
});
