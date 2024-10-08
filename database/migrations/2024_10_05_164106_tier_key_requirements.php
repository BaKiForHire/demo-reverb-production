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
        Schema::create('tier_key_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tier_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_tier_key_id')->constrained('user_tier_keys')->onDelete('cascade');
            $table->boolean('is_required')->default(true); // Indicates if this key is required for the tier
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tier_key_requirements');
    }
};
