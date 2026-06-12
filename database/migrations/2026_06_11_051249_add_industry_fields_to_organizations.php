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
        Schema::table('organizations', function (Blueprint $table) {
            $table->foreignId('industry_id')->nullable()->constrained('industries')->nullOnDelete();
            $table->json('selected_features')->nullable();
            $table->decimal('platform_fee', 10, 2)->default(0.00);
            $table->decimal('feature_fee', 10, 2)->default(0.00);
        });

        Schema::table('pending_rwa_registrations', function (Blueprint $table) {
            $table->foreignId('industry_id')->nullable()->constrained('industries')->nullOnDelete();
            $table->json('selected_features')->nullable();
            $table->decimal('platform_fee', 10, 2)->default(0.00);
            $table->decimal('feature_fee', 10, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign(['industry_id']);
            $table->dropColumn(['industry_id', 'selected_features', 'platform_fee', 'feature_fee']);
        });

        Schema::table('pending_rwa_registrations', function (Blueprint $table) {
            $table->dropForeign(['industry_id']);
            $table->dropColumn(['industry_id', 'selected_features', 'platform_fee', 'feature_fee']);
        });
    }
};
