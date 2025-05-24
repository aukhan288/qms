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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->boolean('published')->default(false);
            $table->unsignedBigInteger('user_id'); 
            $table->string('name');
            $table->enum('category', ['internal documents','procedures','procedures 2023','forms','forms 2023','external documents','archive']);
            $table->enum('document_type', ['pdf', 'word']);
            $table->longText('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
