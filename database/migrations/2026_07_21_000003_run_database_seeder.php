<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Memanggil semua seeder (DatabaseSeeder) secara otomatis
        Artisan::call('db:seed', ['--force' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kosongkan karena seeding data bersifat searah
    }
};
