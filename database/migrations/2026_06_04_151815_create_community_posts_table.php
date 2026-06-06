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
        Schema::create('community_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('member_id'); // Author
            $table->string('title');
            $table->text('content');
            $table->string('image_path')->nullable();
            
            // Moderation Status
            $table->enum('status', ['pending_stage_1', 'pending_stage_2', 'approved', 'rejected'])->default('pending_stage_1');
            
            // AI Moderation
            $table->float('ai_score')->nullable(); // e.g. 0.0 to 100.0 (Higher is safer)
            $table->text('ai_feedback')->nullable();
            
            // Reviewers
            $table->unsignedBigInteger('stage_1_staff_id')->nullable();
            $table->unsignedBigInteger('stage_2_admin_id')->nullable();
            
            $table->timestamps();
            
            // Foreign keys (Optional, uncomment if DB supports and tables are set)
            // $table->foreign('organization_id')->references('id')->on('organization')->onDelete('cascade');
            // $table->foreign('member_id')->references('id')->on('member')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_posts');
    }
};
