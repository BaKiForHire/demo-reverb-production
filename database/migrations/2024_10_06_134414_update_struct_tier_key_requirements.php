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
        // Check if the table exists before making changes
        if (Schema::hasTable('tier_key_requirements')) {
            Schema::table('tier_key_requirements', function (Blueprint $table) {
                // Modify the 'is_required' column if necessary
                $table->boolean('is_required')->default(false)->change();
            });
        } else {
            // If the table does not exist, create it
            Schema::create('tier_key_requirements', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tier_id')->constrained()->onDelete('cascade');
                $table->foreignId('user_tier_key_id')->constrained('user_tier_keys')->onDelete('cascade');
                $table->boolean('is_required')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('tier_key_requirements')) {
            Schema::table('tier_key_requirements', function (Blueprint $table) {
                $table->boolean('is_required')->default(true)->change();
            });
        }
    }
};
