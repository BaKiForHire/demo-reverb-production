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
        Schema::create('favorite_auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // References user id
            $table->foreignId('auction_id')->constrained()->onDelete('cascade'); // References auction id
            $table->timestamp('first_favorited')->nullable(); // When the auction was first favorited
            $table->timestamp('last_unfavorited')->nullable(); // When the auction was last unfavorited
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_auctions');
    }
};
