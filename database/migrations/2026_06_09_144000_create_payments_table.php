<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('razorpay_order_id')->nullable()->index();
            $table->string('razorpay_payment_id')->nullable()->index();
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending'); // pending, success, failed
            $table->string('type'); // donation, rwa_registration, etc.
            $table->string('reference_id')->nullable(); // Can be donor_id or pending_rwa_id
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
