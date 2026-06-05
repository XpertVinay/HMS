<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rwa_vendor_alignment_id')->constrained('rwa_vendor_alignments')->onDelete('cascade');
            $table->integer('member_id');
            $table->enum('vote', ['approve', 'reject']);
            $table->timestamps();
            
            $table->unique(['rwa_vendor_alignment_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_votes');
    }
};
