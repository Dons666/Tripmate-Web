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
            $table->string('payment_status')->default('unpaid')->after('is_checkout'); // unpaid, pending_admin, escrow_held, payout_released
            $table->string('trip_status')->default('planning')->after('payment_status'); // planning, ready, in_progress, completed, cancelled
            $table->string('payment_method')->nullable()->after('trip_status');
            $table->string('payment_ref')->nullable()->after('payment_method');
            $table->timestamp('trip_started_at')->nullable()->after('payment_ref');
            $table->timestamp('trip_ended_at')->nullable()->after('trip_started_at');
            $table->timestamp('payout_released_at')->nullable()->after('trip_ended_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('travel_plans', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'trip_status',
                'payment_method',
                'payment_ref',
                'trip_started_at',
                'trip_ended_at',
                'payout_released_at',
            ]);
        });
    }
};
