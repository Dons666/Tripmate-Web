<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinasi', function (Blueprint $table) {
            if (!Schema::hasColumn('destinasi', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('alamat');
            }

            if (!Schema::hasColumn('destinasi', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('destinasi', function (Blueprint $table) {
            $dropColumns = [];

            if (Schema::hasColumn('destinasi', 'latitude')) {
                $dropColumns[] = 'latitude';
            }

            if (Schema::hasColumn('destinasi', 'longitude')) {
                $dropColumns[] = 'longitude';
            }

            if (!empty($dropColumns)) {
                $table->dropColumn($dropColumns);
            }
        });
    }
};
