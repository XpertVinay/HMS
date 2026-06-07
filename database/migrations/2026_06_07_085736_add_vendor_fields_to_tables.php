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
        Schema::table('organizations', function (Blueprint $table) {
            $table->integer('vendor_acceptance_timeout_minutes')->default(30)->after('status');
        });

        Schema::table('vendor', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('global_rating');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->string('vendor_category', 100)->nullable()->after('assigned_vendor_id');
            $table->integer('vendor_broadcast_phase')->default(0)->after('vendor_category');
            $table->timestamp('vendor_broadcast_started_at')->nullable()->after('vendor_broadcast_phase');
            $table->string('vendor_service_status', 50)->nullable()->after('vendor_broadcast_started_at'); // broadcasting, accepted, negotiating, escalated, completed
        });

        Schema::create('ticket_vendor_passes', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket_id');
            $table->integer('vendor_id');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendor')->onDelete('cascade');
        });

        Schema::table('vendor_invoice', function (Blueprint $table) {
            $table->integer('ticket_id')->nullable()->after('vendor_id');
            $table->text('task_details')->nullable()->after('ticket_id');
            $table->integer('member_id')->nullable()->after('organization_id');
            $table->integer('resident_id')->nullable()->after('member_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_invoice', function (Blueprint $table) {
            $table->dropColumn(['ticket_id', 'task_details', 'member_id', 'resident_id']);
        });

        Schema::dropIfExists('ticket_vendor_passes');

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['vendor_category', 'vendor_broadcast_phase', 'vendor_broadcast_started_at', 'vendor_service_status']);
        });

        Schema::table('vendor', function (Blueprint $table) {
            $table->dropColumn('is_featured');
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('vendor_acceptance_timeout_minutes');
        });
    }
};
