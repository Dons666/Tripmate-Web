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
        Schema::table('travel_plans', function (Blueprint $table) {
            $table->foreignId('travel_id')
                ->nullable()
                ->after('user_id')
                ->constrained('travels')
                ->nullOnDelete();
            $table->boolean('is_checkout')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_plans', function (Blueprint $table) {
            $table->dropForeign(['travel_id']);
            $table->dropColumn(['travel_id', 'is_checkout']);
        });
    }
};
