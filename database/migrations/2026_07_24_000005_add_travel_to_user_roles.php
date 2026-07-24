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
            DB::statement("ALTER TABLE users MODIFY role VARCHAR(255) NOT NULL DEFAULT 'user';");
        } catch (\Throwable $e) {
            // Fallback for drivers
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
