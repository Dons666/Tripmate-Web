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
        Schema::table('penyedia_travel', function (Blueprint $table) {
            if (!Schema::hasColumn('penyedia_travel', 'foto_kendaraan')) {
                $table->string('foto_kendaraan')->nullable()->after('jenis_kendaraan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penyedia_travel', function (Blueprint $table) {
            if (Schema::hasColumn('penyedia_travel', 'foto_kendaraan')) {
                $table->dropColumn('foto_kendaraan');
            }
        });
    }
};
