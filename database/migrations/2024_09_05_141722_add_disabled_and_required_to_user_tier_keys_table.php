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
        Schema::table('user_tier_keys', function (Blueprint $table) {
            $table->boolean('disabled')->default(false)->after('is_active');
            $table->boolean('required')->default(false)->after('disabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_tier_keys', function (Blueprint $table) {
            $table->dropColumn('disabled');
            $table->dropColumn('required');
        });
    }
};
