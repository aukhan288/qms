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
        Schema::create('tool_calibration_records', function (Blueprint $table) {
            $table->id();
            $table->string('item_of_equipment');
            $table->string('serial_number')->nullable();
            $table->text('description')->nullable();
            $table->string('calibration_checking_requirements')->nullable();
            $table->string('measurement_ref_standard')->nullable();
            $table->date('date_purchased')->nullable();
            $table->date('date_calibrated')->nullable();
            $table->date('serviced_or_checked_date')->nullable();
            $table->date('next_calibration_date')->nullable();
            $table->text('out_of_spec_reading_at_calibration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tool_calibration_records');
    }
};
