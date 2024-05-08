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
        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_class_id')
                ->constrained('teacher_classes');
            $table->foreignId('student_id')
                ->nullable()
                ->constrained('students');
            $table->foreignId('faculty_member_id')
                ->nullable()
                ->constrained('faculty_members');
            $table->foreignId('sy_id')
                ->constrained('school_years');
            $table->foreignId('semester_id')
                ->constrained('semesters');
            $table->string('remarks'); // present, absent, late
            $table->dateTime('time_in');
            $table->dateTime('time_out')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_logs');
    }
};
