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
        Schema::create('projects_folders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); 
              // Project Information
            $table->string('project_reference')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('county')->nullable();
            $table->string('postcode')->nullable();
            $table->string('email')->nullable();
            $table->string('land_line_number')->nullable();
            $table->string('mobile_number')->nullable();

            // Retrofit Coordinator
            $table->string('retrofit_coordinator_name')->nullable();
            $table->string('retrofit_coordinator_contact_number')->nullable();
            $table->string('retrofit_coordinator_email')->nullable();

            // EEM Specifier Information
            $table->string('eem_specifier')->nullable();
            $table->string('eem_specifier_contact_name')->nullable();
            $table->string('eem_specifier_office_phone')->nullable();
            $table->string('eem_specifier_email')->nullable();

            // Key Installation Dates
            $table->date('start_date')->nullable();
            $table->date('contract_completed_date')->nullable();

            // Measures to be installed (assuming multiple selections stored as JSON)
            $table->json('measures_to_be_installed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_folders');
    }
};
