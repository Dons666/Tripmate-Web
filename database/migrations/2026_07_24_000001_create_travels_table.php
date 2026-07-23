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
        if (!Schema::hasTable('travels')) {
            Schema::create('travels', function (Blueprint $table) {
                $table->id();
                $table->string('nama_travel');
                $table->string('slug')->unique();
                $table->string('layanan')->nullable(); // e.g. "Paket Tur Lengkap & Driver"
                $table->text('deskripsi')->nullable();
                $table->decimal('harga_paket', 12, 2)->default(0);
                $table->decimal('rating', 3, 2)->default(4.5);
                $table->string('kota')->nullable();
                $table->string('kontak')->nullable();
                $table->text('gambar')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travels');
    }
};
