<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tables that are missing the `updated_at` timestamp column.
     * These models rely on Eloquent timestamps but the column was never added.
     */
    private array $tables = [
        'announcement',
        'donors',
        'events',
        'organizations',
        'property',
        'registry',
        'sponsors',
        'tickets',
        'vendor_invoice',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'updated_at')) {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->timestamp('updated_at')->nullable()->after('created_at');
                });
            }
        }

        // Gallery uses `uploaded_at` instead of `created_at` and sets UPDATED_AT = null,
        // so it does NOT need an updated_at column.

        // Vendor table sets UPDATED_AT = null in the AppVendor model,
        // so it does NOT need an updated_at column.

        // Maintenance & MaintenanceItem have $timestamps = false,
        // so they do NOT need timestamp columns.
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
