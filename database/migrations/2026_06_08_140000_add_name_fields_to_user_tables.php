<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** @var array<string, string> table => column to place names after */
    private array $userTables = [
        'super_admin' => 'username',
        'admin' => 'username',
        'staff' => 'username',
        'member' => 'username',
        'resident' => 'username',
        'vendor' => 'business_name',
    ];

    public function up(): void
    {
        foreach ($this->userTables as $tableName => $afterColumn) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName, $afterColumn) {
                if (! Schema::hasColumn($tableName, 'first_name')) {
                    $table->string('first_name', 100)->nullable()->after($afterColumn);
                }
                if (! Schema::hasColumn($tableName, 'last_name')) {
                    $table->string('last_name', 100)->nullable()->after('first_name');
                }
            });
        }
    }

    public function down(): void
    {
        foreach (array_keys($this->userTables) as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $columns = [];
                if (Schema::hasColumn($tableName, 'last_name')) {
                    $columns[] = 'last_name';
                }
                if (Schema::hasColumn($tableName, 'first_name')) {
                    $columns[] = 'first_name';
                }
                if ($columns !== []) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
