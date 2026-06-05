<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rwa_vendor_alignments', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->foreignId('vendor_id')->constrained('vendor')->onDelete('cascade');
            $table->enum('status', ['proposed', 'voting', 'admin_approved', 'rejected', 'active'])->default('proposed');
            $table->timestamp('voting_ends_at')->nullable();
            $table->timestamps();
            
            $table->unique(['organization_id', 'vendor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rwa_vendor_alignments');
    }
};
