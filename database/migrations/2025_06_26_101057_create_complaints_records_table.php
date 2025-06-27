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
        Schema::create('complaints_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('projects_folders_id')->constrained()->onDelete('cascade');
            $table->enum('source', ['Customer', 'Installer', 'Employee', 'Other']);


            $table->string('complainant_name');
            $table->date('date_of_complaint')->nullable();
            $table->text('address')->nullable();

            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_mobile')->nullable();

            $table->string('handled_by')->nullable();
            $table->text('nature_of_complaint')->nullable();
            $table->text('immediate_action_required')->nullable();
            $table->text('outcome')->nullable();

            $table->boolean('resolved_within_5_days')->nullable();
            $table->text('resolution_comments')->nullable();

            $table->text('findings')->nullable();
            $table->text('summary_of_findings')->nullable();

            $table->string('attachment_path')->nullable();

            $table->boolean('closed_out')->default(false);
            $table->string('verified_by')->nullable();
            $table->string('validator_position')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints_records');
    }
};
