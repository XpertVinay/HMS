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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('organization_id')->nullable()->after('id');
            $table->string('username', 50)->nullable()->unique()->after('name');
            $table->string('mobile_number', 20)->nullable()->after('email');
            $table->string('address', 255)->nullable()->after('mobile_number');
            $table->string('status', 20)->default('active')->after('address');
            $table->boolean('is_verified')->default(false)->after('status');
            $table->json('user_meta')->nullable()->after('is_verified')->comment('Store dynamic organization specific fields');

            $table->foreign('organization_id')->references('id')->on('organizations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn([
                'organization_id',
                'username',
                'mobile_number',
                'address',
                'status',
                'is_verified',
                'user_meta'
            ]);
        });
    }
};
