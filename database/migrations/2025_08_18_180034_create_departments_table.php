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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            // $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade');
            // $table->string('head_of_department')->nullable(); // Optional field for the head of department
            // $table->string('contact_email')->nullable(); // Optional field for contact email
            // $table->string('contact_phone')->nullable(); // Optional field for contact phone number
            // $table->boolean('is_active')->default(true); // Field to indicate if the department is active
            $table->string('created_by')->nullable(); // Field to track who created the department
            $table->string('updated_by')->nullable(); // Field to track who last updated the department
            $table->string('deleted_by')->nullable(); // Field to track who deleted
            $table->timestamps();
            $table->softDeletes(); // Soft delete field to allow for soft deletion of departments
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
