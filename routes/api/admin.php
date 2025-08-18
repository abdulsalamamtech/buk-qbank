<?php

use Illuminate\Support\Facades\Route;



// Protected product routes
Route::prefix('admin')
    ->middleware(['auth:sanctum', 'role:super-admin'])
    ->name('admin.')
    ->group(function () {
        // Route::apiResource('products', ProductController::class);

        // Test if user has access to dashboard
        Route::get('dashboard', function () {
            return "You have access to the admin dashboard";
        });
    });
