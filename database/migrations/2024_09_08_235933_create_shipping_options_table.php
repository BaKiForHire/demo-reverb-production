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
        Schema::create('shipping_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_id')->constrained()->onDelete('cascade'); // Link to the auction
            $table->string('type');                                              // Type of shipping (e.g., Standard, Express)
            $table->decimal('cost', 8, 2);                                       // Cost of shipping
            $table->text('details')->nullable();                                 // Additional details about the shipping option
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
        Schema::dropIfExists('shipping_options');
    }
};
