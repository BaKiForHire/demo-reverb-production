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
        Schema::create('user_tier_keys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('identifier')->unique();
            $table->foreignId('tier_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->enum('data_type', ['string', 'boolean', 'date', 'dropdown', 'file']);
            $table->text('validation_rules')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tier_keys');
    }
};
