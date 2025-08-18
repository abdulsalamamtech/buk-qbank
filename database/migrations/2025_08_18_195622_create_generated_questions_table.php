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
        Schema::create('generated_questions', function (Blueprint $table) {
            // -   question_type (Test,Exam)
            // -   year (2021/2022)
            // -   course_id (SWE1309)
            // -   level (100, 200, 300, 400)
            // -   semester (first or second)
            // -   objective_instruction (none)
            // -   objective_total (1, 20, 30, 50, 100)
            // -   objective_questions [] (from backend)
            // -   theory_instruction (none)
            // -   theory_question_no (1, 3, 4, 5)
            // -   theory_questions [] (from backend)
            // -   created_by (the user id)            
            $table->id();
            $table->string('question_type')->comment('test, exam'); // test, exam
            $table->text('year')->comment('2020/2021'); 
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('level')->comment('100'); 
            $table->string('semester')->comment('first or second'); // 1 for first 2 second

            $table->text('objective_instruction')->comment('answer all question'); 
            $table->integer('objective_total')->comment('total number of question');
            $table->json('objective_questions')->nullable(); // [ids of question]

            $table->text('theory_instruction')->comment('answer all question'); 
            $table->integer('theory_total')->comment('total number of question');
            $table->json('theory_questions')->nullable(); // [ids of question]

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
        Schema::dropIfExists('generated_questions');
    }
};
