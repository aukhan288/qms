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
        Schema::create('installation_audit_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('installation_type')->constrained()->onDelete('cascade');
            $table->date('audit_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->string('installation_reference_number')->nullable();
            $table->date('installation_date')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('auditor')->nullable();
            $table->enum('transferred_to_GDR_02', ['Yes', 'No']);
            $table->text('project_folder_comments')->nullable();
            $table->text('summary')->nullable();
            $table->text('corrective_preventive_actions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installation_audit_records');
    }
};
