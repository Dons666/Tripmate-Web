<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            DB::statement("ALTER TABLE penyedia_travel MODIFY alamat_travel TEXT NULL;");
            DB::statement("ALTER TABLE penyedia_travel MODIFY kota_asal_travel VARCHAR(255) NULL;");
            DB::statement("ALTER TABLE penyedia_travel MODIFY jenis_kendaraan VARCHAR(255) NULL;");
            DB::statement("ALTER TABLE penyedia_travel MODIFY harga DECIMAL(12,2) NULL DEFAULT 0;");
            DB::statement("ALTER TABLE penyedia_travel MODIFY jadwal_ketersediaan TEXT NULL;");
            DB::statement("ALTER TABLE penyedia_travel MODIFY rekening VARCHAR(255) NULL;");
        } catch (\Throwable $e) {
            // Ignore if DB driver doesn't support raw ALTER
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
