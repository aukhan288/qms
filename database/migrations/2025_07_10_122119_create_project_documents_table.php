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
            Schema::create('project_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_folder_id')->constrained('projects_folders')->onDelete('cascade');

            // Add this line for measure reference
            $table->unsignedBigInteger('upload_measure');

            $table->string('filename');
            $table->string('path');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();

            $table->timestamps();

            // Optional foreign key if you want to link to `project_measures`
            $table->foreign('upload_measure')->references('id')->on('project_measures')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_documents');
    }
};
