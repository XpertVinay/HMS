<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_devices', function (Blueprint $table) {
            $table->string('fcm_token', 512)->nullable()->after('device_model');
            $table->index(['user_type', 'user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('user_devices', function (Blueprint $table) {
            $table->dropIndex(['user_type', 'user_id', 'status']);
            $table->dropColumn('fcm_token');
        });
    }
};
