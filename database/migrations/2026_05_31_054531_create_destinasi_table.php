<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_destinasi');
            $table->enum('tipe', ['wisata', 'kuliner', 'penginapan']);
            $table->string('kota');
            $table->string('kategori');
            $table->decimal('harga', 12, 2)->default(0);
            $table->boolean('hidden_gem')->default(false);
            $table->text('deskripsi')->nullable();
            $table->text('fasilitas')->nullable();
            $table->longText('fitur_cbf')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinasi');
    }
};