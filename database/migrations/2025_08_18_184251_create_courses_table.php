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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Elementary mathematics'); 
            $table->string('code')->comment('MTH1301'); 
            $table->string('level')->comment('100'); 
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
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
        Schema::dropIfExists('courses');
    }
};
