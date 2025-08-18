<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\GeneratedQuestionController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;







// Protected product routes
Route::middleware(['auth:sanctum', 'role:super-admin'])
    ->group(function () {
        // Route::apiResource('products', ProductController::class);

        // Test if user has access to app
        Route::get('app', function () {
            return "You have access to the admin app";
        });

        // department routes
        Route::apiResource('departments', DepartmentController::class);

        // course routes
        Route::apiResource('courses', CourseController::class);

        // question routes
        Route::apiResource('questions', QuestionController::class);

        // Generated Question routes
        Route::apiResource('generated-questions', GeneratedQuestionController::class);

        // Generate PDF route
        Route::get('generated-questions/{generatedQuestion}/pdf', [GeneratedQuestionController::class, 'generatePdf'])
            ->name('generated-questions.pdf');
    });
