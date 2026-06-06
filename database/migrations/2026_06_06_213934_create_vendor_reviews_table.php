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
        Schema::create('vendor_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendor')->onDelete('cascade');
            $table->integer('member_id');
            $table->foreign('member_id')->references('id')->on('member')->onDelete('cascade');
            $table->integer('rating'); // 1 to 5
            $table->text('review_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_reviews');
    }
};
