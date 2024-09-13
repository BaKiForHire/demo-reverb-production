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
        Schema::create('payout_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_id')->constrained()->onDelete('cascade'); // Link to the auction
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade'); // Link to the seller
            $table->decimal('amount', 10, 2);                                    // Requested payout amount
            $table->string('status')->default('pending');                        // Payout status: pending, approved, rejected
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
        Schema::dropIfExists('payout_requests');
    }
};
