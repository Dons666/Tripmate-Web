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
        Schema::table('destinasi', function (Blueprint $table) {
            // Drop gambar jika masih ada, recreate dengan tipe text untuk URL panjang
            if (Schema::hasColumn('destinasi', 'gambar')) {
                $table->dropColumn('gambar');
            }
        });
        
        Schema::table('destinasi', function (Blueprint $table) {
            if (!Schema::hasColumn('destinasi', 'gambar')) {
                $table->text('gambar')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinasi', function (Blueprint $table) {
            if (Schema::hasColumn('destinasi', 'gambar')) {
                $table->dropColumn('gambar');
            }
        });
        
        Schema::table('destinasi', function (Blueprint $table) {
            if (!Schema::hasColumn('destinasi', 'gambar')) {
                $table->string('gambar', 500)->nullable();
            }
        });
    }
};