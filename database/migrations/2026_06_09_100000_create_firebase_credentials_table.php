<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('firebase_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('project_key', 50)->default('app')->unique();
            $table->json('credentials');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('firebase_credentials');
    }
};
