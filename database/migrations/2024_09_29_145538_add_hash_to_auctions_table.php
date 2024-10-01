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
        // Add a hash column to the auctions table
        Schema::table('auctions', function (Blueprint $table) {
            $table->string('hash')->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the hash column from the auctions table
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropColumn('hash');
        });
    }
};
