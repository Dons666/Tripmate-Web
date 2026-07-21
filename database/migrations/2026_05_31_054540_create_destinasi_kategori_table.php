<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinasi_kategori', function (Blueprint $table) {
            $table->foreignId('destinasi_id')->constrained('destinasi')->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('kategori')->cascadeOnDelete();
            $table->primary(['destinasi_id', 'kategori_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinasi_kategori');
    }
};