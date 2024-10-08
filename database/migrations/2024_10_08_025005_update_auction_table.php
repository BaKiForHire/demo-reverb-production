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
        Schema::table('auctions', function (Blueprint $table) {
            $table->boolean('can_make_offer')->default(false);
            $table->boolean('is_buy_now')->default(false);
            $table->boolean('is_auction')->default(true);
            $table->decimal('reserve_price', 10, 2)->nullable();
            $table->decimal('buy_now_price', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn('can_make_offer');
            $table->dropColumn('is_buy_now');
            $table->dropColumn('is_auction');
            $table->dropColumn('reserve_price');
            $table->dropColumn('buy_now_price');
        });
    }
};
