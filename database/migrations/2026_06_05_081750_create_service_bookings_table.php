<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->integer('member_id');
            $table->foreignId('vendor_service_id')->constrained('vendor_services')->onDelete('cascade');
            
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled', 'closed'])->default('pending');
            $table->enum('payment_method', ['online', 'offline', 'unpaid'])->default('unpaid');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->text('closing_remarks')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_bookings');
    }
};
