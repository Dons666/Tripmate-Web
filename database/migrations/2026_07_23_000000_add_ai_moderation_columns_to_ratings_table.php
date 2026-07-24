<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->boolean('is_flagged')->default(false)->after('komentar');
            $table->string('flag_reason', 500)->nullable()->after('is_flagged');
            $table->timestamp('ai_checked_at')->nullable()->after('flag_reason');
        });
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropColumn(['is_flagged', 'flag_reason', 'ai_checked_at']);
        });
    }
};
