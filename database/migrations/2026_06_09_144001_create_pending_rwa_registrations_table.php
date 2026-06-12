<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pending_rwa_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('org_name');
            $table->text('org_address');
            $table->string('registration_code');
            $table->string('subdomain');
            $table->string('admin_username');
            $table->string('admin_first_name')->nullable();
            $table->string('admin_last_name')->nullable();
            $table->string('admin_email');
            $table->string('admin_password'); // Hashed password
            $table->decimal('fee_amount', 10, 2)->default(2499.00);
            $table->string('status')->default('pending_payment'); // pending_payment, paid, converted
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_rwa_registrations');
    }
};
