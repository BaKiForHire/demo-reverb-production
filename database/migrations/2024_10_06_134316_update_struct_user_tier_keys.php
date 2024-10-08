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
            // Add new columns or modify existing ones if they don't already exist
            if (!Schema::hasColumn('user_tier_keys', 'parent_key_id')) {
                $table->foreignId('parent_key_id')->nullable()->constrained('user_tier_keys')->onDelete('cascade');
            }

            if (!Schema::hasColumn('user_tier_keys', 'condition_value')) {
                $table->string('condition_value')->nullable();
            }

            if (!Schema::hasColumn('user_tier_keys', 'dropdown_values')) {
                $table->json('dropdown_values')->nullable();
            }

            // Drop unnecessary columns if they exist
            if (Schema::hasColumn('user_tier_keys', 'disabled')) {
                $table->dropColumn('disabled');
            }

            if (Schema::hasColumn('user_tier_keys', 'required')) {
                $table->dropColumn('required');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_tier_keys', function (Blueprint $table) {
            // Reverse the changes made in the 'up' method
            if (Schema::hasColumn('user_tier_keys', 'parent_key_id')) {
                $table->dropForeign(['parent_key_id']);
                $table->dropColumn('parent_key_id');
            }

            if (Schema::hasColumn('user_tier_keys', 'condition_value')) {
                $table->dropColumn('condition_value');
            }

            if (Schema::hasColumn('user_tier_keys', 'dropdown_values')) {
                $table->dropColumn('dropdown_values');
            }

            // Add back the dropped columns if necessary
            $table->boolean('disabled')->default(false);
            $table->boolean('required')->default(false);
        });
    }
};
