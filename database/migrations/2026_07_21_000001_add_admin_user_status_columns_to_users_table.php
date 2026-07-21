<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('role');
            }

            if (!Schema::hasColumn('users', 'warning_count')) {
                $table->unsignedTinyInteger('warning_count')->default(0)->after('is_active');
            }

            if (!Schema::hasColumn('users', 'deactivation_reason_code')) {
                $table->string('deactivation_reason_code')->nullable()->after('warning_count');
            }

            if (!Schema::hasColumn('users', 'deactivation_reason_detail')) {
                $table->text('deactivation_reason_detail')->nullable()->after('deactivation_reason_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $dropColumns = [];

            foreach (['is_active', 'warning_count', 'deactivation_reason_code', 'deactivation_reason_detail'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $dropColumns[] = $column;
                }
            }

            if (!empty($dropColumns)) {
                $table->dropColumn($dropColumns);
            }
        });
    }
};
