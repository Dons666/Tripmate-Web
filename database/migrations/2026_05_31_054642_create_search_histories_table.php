<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('search_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('destinasi_id')->nullable()->constrained('destinasi')->cascadeOnDelete();
            $table->string('keyword_search');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('search_histories');
    }
};