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

            $table->text('alamat')->nullable()->after('fasilitas');

            $table->text('transportasi')->nullable()->after('alamat');

            $table->string('jam_buka')->nullable()->after('transportasi');

            $table->string('jam_tutup')->nullable()->after('jam_buka');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinasi', function (Blueprint $table) {

            $table->dropColumn([
                'alamat',
                'transportasi',
                'jam_buka',
                'jam_tutup'
            ]);

        });
    }
};