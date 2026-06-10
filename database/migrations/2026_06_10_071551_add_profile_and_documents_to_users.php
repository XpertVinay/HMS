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
        $tables = ['super_admin', 'admin', 'staff', 'member', 'resident', 'vendor', 'users'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->string('profile_image', 255)->nullable();
            });
        }

        Schema::table('admin', function (Blueprint $table) {
            $table->json('gallery_images')->nullable();
            $table->json('other_documents')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn(['gallery_images', 'other_documents']);
        });

        $tables = ['super_admin', 'admin', 'staff', 'member', 'resident', 'vendor', 'users'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropColumn('profile_image');
            });
        }
    }
};
