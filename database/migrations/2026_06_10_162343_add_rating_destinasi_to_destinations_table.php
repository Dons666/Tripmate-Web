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
        // UBAH 'destinations' MENJADI 'destinasi'
        Schema::table('destinasi', function (Blueprint $table) {
            $table->decimal('rating_destinasi', 3, 2)->default(0.00)->after('hidden_gem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // UBAH 'destinations' MENJADI 'destinasi'
        Schema::table('destinasi', function (Blueprint $table) {
            $table->dropColumn('rating_destinasi');
        });
    }
};