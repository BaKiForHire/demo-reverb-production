<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_tier_key_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('user_tier_key_id');
            $table->text('value')->nullable(); // Store the value entered by the user
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_tier_key_id')->references('id')->on('user_tier_keys')->onDelete('cascade');

            // Prevent duplicate entries for the same user and key
            $table->unique(['user_id', 'user_tier_key_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('user_tier_key_values');
    }
};
