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
