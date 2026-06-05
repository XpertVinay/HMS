<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendor', function (Blueprint $table) {
            $table->dropColumn('organization_id');
            $table->decimal('global_rating', 3, 2)->default(0);
            $table->integer('total_tasks_completed')->default(0);
            $table->boolean('is_active_globally')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('vendor', function (Blueprint $table) {
            $table->integer('organization_id')->nullable();
            $table->dropColumn(['global_rating', 'total_tasks_completed', 'is_active_globally']);
        });
    }
};
