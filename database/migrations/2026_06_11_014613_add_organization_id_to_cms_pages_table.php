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
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->integer('organization_id')->nullable()->after('id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');

            $table->dropUnique('cms_pages_slug_unique');
            $table->unique(['organization_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->dropUnique(['organization_id', 'slug']);
            $table->unique('slug');
            
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });
    }
};
