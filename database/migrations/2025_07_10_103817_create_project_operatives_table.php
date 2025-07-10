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
       Schema::create('project_operatives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('operative_id');
            $table->unsignedBigInteger('project_measure_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('project_id')
                  ->references('id')->on('projects_folders')->onDelete('cascade');

            $table->foreign('operative_id')
                  ->references('id')->on('personal_skills_and_training')->onDelete('cascade');

            $table->foreign('project_measure_id')
                  ->references('id')->on('project_measures')->onDelete('cascade');

            // Unique constraint to prevent duplicates
            $table->unique(['project_id', 'operative_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_operatives');
    }
};
