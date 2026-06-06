<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor_advertisements', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendor')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('target_url')->nullable();
            $table->enum('status', ['pending', 'active', 'rejected', 'expired'])->default('pending');
            $table->decimal('advertisement_fee', 10, 2)->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_advertisements');
    }
};
