<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_id')->constrained()->onDelete('cascade'); // Link to the auction
            $table->foreignId('user_id')->constrained()->onDelete('cascade');    // Link to the buyer (user)
            $table->decimal('amount', 10, 2);                                   // The payment amount
            $table->string('status')->default('pending');                       // Payment status: pending, successful, failed
            $table->string('payment_method');                                   // Payment method used (e.g., card, Pay on Delivery)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
