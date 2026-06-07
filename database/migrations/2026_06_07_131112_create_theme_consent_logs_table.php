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
        Schema::create('theme_consent_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->integer('admin_id');
            $table->string('action')->default('Theme Updated');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('theme_data')->nullable();
            $table->timestamps();

            $table->foreign('organization_id')->references('id')->on('organizations')->cascadeOnDelete();
            $table->foreign('admin_id')->references('id')->on('admin')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_consent_logs');
    }
};
