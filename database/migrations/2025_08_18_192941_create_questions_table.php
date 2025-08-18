<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
        // -   course_id
        // -   type (essay,boolean(true/false),(multiple)multi-choice) [only objective and theory]
        // -   question
        // -   answer
        // -   options[] array from 0 to 4
        // -   status (pending, approved, rejected)
        // -   asset_id
        // -   created_by (the user id)
        // -   approved_by (the user id)            
            $table->id();
            $table->string('type')->comment('objective, theory'); // objective, theory, essay, boolean, multiple
            $table->text('question')->comment('what school are you?'); 
            $table->text('answer')->comment('buk'); 
            $table->json('options')->nullable(); // [max of 4 options]
            $table->string('status')->default('pending')->comment('(pending, approved, rejected'); 
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('asset_id')->nullable()->constrained('assets')->onDelete('cascade');
            // approved by
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('cascade');
            // Field to track who created the department
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            // Field to track who last updated the department
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
            // Field to track who deleted
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes(); // Soft delete field to allow for soft deletion of departments
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
