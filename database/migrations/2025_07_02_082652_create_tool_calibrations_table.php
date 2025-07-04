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
        Schema::create('tool_calibrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('item_of_equipment');
            $table->string('serial_number')->nullable();
            $table->text('description')->nullable();
            $table->text('calibration_checking_requirements')->nullable();
            $table->string('measurement_ref_standard')->nullable();
            $table->date('date_purchased')->nullable();
            $table->date('date_calibrated')->nullable();
            $table->date('serviced_or_checked')->nullable();
            $table->date('next_calibration_date')->nullable();
            $table->string('out_of_spec_reading_at_calibration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tool_calibrations');
    }
};
