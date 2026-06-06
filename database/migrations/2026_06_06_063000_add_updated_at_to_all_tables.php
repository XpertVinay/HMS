<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tables that might be missing the `updated_at` timestamp column.
     */
    private array $tables = [
        'organizations',
        'super_admin',
        'admin',
        'staff',
        'member',
        'resident',
        'property',
        'vendor',
        'vendor_invoice',
        'announcement',
        'donors',
        'events',
        'gallery',
        'maintenance',
        'maintenance_items',
        'registry',
        'sponsors',
        'tickets',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'updated_at')) {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->timestamp('updated_at')->nullable();
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'updated_at')) {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->dropColumn('updated_at');
                });
            }
        }
    }
};
