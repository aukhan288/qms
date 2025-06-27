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
        Schema::create('skills_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('skill_id')->index();
            $table->string('course_name');
            $table->date('course_date');
            $table->date('renewal_date');
            $table->text('course_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills_courses');
    }
};
