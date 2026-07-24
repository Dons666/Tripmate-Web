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
        Schema::create('destinasi_travel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_id')->constrained('travels')->cascadeOnDelete();
            $table->foreignId('destinasi_id')->constrained('destinasi')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinasi_travel');
    }
};
