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
        Schema::table('organization_menu_configs', function (Blueprint $table) {
            $table->json('menu_hierarchy')->nullable()->after('enabled_menus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organization_menu_configs', function (Blueprint $table) {
            $table->dropColumn('menu_hierarchy');
        });
    }
};
