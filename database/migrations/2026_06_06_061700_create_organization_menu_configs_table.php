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
        Schema::create('organization_menu_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')
                  ->unique()
                  ->constrained('organizations')
                  ->cascadeOnDelete();
            $table->json('enabled_menus')->comment('Array of enabled menu item keys');
            $table->timestamps();
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->string('location')->nullable()->after('address');
            $table->string('residential_type')->nullable()->after('location')
                  ->comment('apartment|villa|independent_house|township|commercial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_menu_configs');

        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn(['location', 'residential_type']);
        });
    }
};
