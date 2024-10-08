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
            $table->unsignedBigInteger('parent_key_id')->nullable()->after('data_type');
            $table->string('condition_value')->nullable()->after('parent_key_id');
            $table->boolean('is_optional')->default(false)->after('condition_value');

            $table->foreign('parent_key_id')->references('id')->on('user_tier_keys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_tier_keys', function (Blueprint $table) {
            $table->dropForeign(['parent_key_id']);
            $table->dropColumn(['parent_key_id', 'condition_value', 'is_optional']);
        });
    }
};
