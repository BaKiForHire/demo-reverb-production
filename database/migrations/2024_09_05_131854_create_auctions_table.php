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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('start_price', 10, 2);
            $table->decimal('current_price', 10, 2);
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['active', 'frozen', 'ended']);
            $table->string('media_url')->nullable();  // For storing image/video URL
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
