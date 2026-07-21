<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('travel_plans', function (Blueprint $table) {
            $table->string('tujuan')->nullable()->after('nama_perjalanan');
            $table->text('catatan')->nullable()->after('tujuan');
            $table->string('status')->default('Perencanaan Aktif')->after('budget');
            $table->string('foto_sampul')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('travel_plans', function (Blueprint $table) {
            $table->dropColumn(['tujuan', 'catatan', 'status', 'foto_sampul']);
        });
    }
};