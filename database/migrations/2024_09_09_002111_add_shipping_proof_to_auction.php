<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->boolean('has_shipping_proof')->default(false); // Tracks if shipping proof has been submitted
            $table->string('shipping_proof_url')->nullable();      // Optional URL for proof of shipping (could be a file path)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn('has_shipping_proof');
            $table->dropColumn('shipping_proof_url');
        });
    }
};
