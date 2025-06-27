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
        Schema::create('company_documents', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Insurance', 'Warranty', 'Compliance Certificate', 'Other']);
            $table->string('name'); // Document name
            $table->unsignedBigInteger('user_id'); 
            $table->text('description')->nullable(); // Optional description
            $table->date('date'); // Issue or creation date
            $table->date('renewal_date')->nullable(); // Optional renewal/expiry date
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_documents');
    }
};
