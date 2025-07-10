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
        Schema::create('corrective_preventive_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date')->nullable();
            $table->string('ncr_no')->nullable();
            $table->string('source')->nullable();
            $table->enum('preventive_or_Corrective', ['corrective', 'preventive']);
            $table->string('issued_to')->nullable();
            $table->integer('no_of_days')->nullable();
            $table->date('date_closed')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->string('closed_by')->nullable();
            $table->text('details_of_issue')->nullable();
            $table->text('summary_of_action_taken')->nullable();
            $table->text('root_cause')->nullable();
            $table->text('prevent_recurrence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corrective_preventive_actions');
    }
};
