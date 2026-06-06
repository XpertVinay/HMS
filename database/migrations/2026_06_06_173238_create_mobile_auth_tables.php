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
        Schema::create('qr_auth_tokens', function (Blueprint $table) {
            $table->string('token', 255)->primary();
            $table->string('user_type', 50);
            $table->integer('user_id');
            $table->integer('organization_id');
            $table->timestamp('expires_at');
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });

        Schema::create('user_devices', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('user_type', 50);
            $table->integer('user_id');
            $table->integer('organization_id');
            $table->string('device_uuid', 255)->unique();
            $table->enum('os_type', ['ios', 'android', 'web'])->default('android');
            $table->string('device_model', 100)->nullable();
            $table->enum('status', ['active', 'revoked'])->default('active');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('user_type', 50)->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('organization_id')->nullable();
            $table->string('action', 100);
            $table->string('ip_address', 45)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('user_devices');
        Schema::dropIfExists('qr_auth_tokens');
    }
};
