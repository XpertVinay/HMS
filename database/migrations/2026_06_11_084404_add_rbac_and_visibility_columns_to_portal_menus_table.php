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
        Schema::table('portal_menus', function (Blueprint $table) {
            $table->enum('visibility', ['public', 'dashboard', 'both'])->default('public')->after('target');
            $table->json('roles')->nullable()->after('visibility');
            $table->json('permissions')->nullable()->after('roles');
            $table->string('icon')->nullable()->after('permissions');
            $table->string('route_name')->nullable()->after('icon');
            $table->boolean('is_preset')->default(false)->after('route_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portal_menus', function (Blueprint $table) {
            $table->dropColumn(['visibility', 'roles', 'permissions', 'icon', 'route_name', 'is_preset']);
        });
    }
};
