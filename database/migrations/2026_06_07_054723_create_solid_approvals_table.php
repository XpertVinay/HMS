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
        Schema::create('solid_approvals', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id')->nullable();
            $table->integer('member_id');
            $table->string('approval_type');
            $table->string('status')->default('pending'); // pending, stage_1_approved, approved, rejected
            $table->text('description')->nullable();
            $table->decimal('charge_amount', 10, 2)->nullable();
            $table->integer('maintenance_id')->nullable();
            $table->integer('stage_1_staff_id')->nullable();
            $table->integer('stage_2_admin_id')->nullable();
            $table->string('document_path')->nullable();
            $table->timestamps();
            
            // Note: Add foreign keys if applicable, but base tables use integer without constraint heavily, so we'll stick to basic integer IDs.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solid_approvals');
    }
};
