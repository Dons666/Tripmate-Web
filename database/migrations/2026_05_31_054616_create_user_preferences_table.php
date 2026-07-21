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
        Schema::create('user_preferences', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Kota tujuan yang dipilih user
            $table->string('kota_preferensi');

            // Minat wisata (bisa lebih dari satu)
            $table->json('minat_wisata')->nullable();

            // Preferensi hidden gem
            $table->boolean('hidden_gem')->default(false);

            // Kategori harga:
            // Gratis, Murah, Sedang, Mahal
            $table->string('budget')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};
