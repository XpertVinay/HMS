<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixVendorTables extends Command
{
    protected $signature = 'fix:vendor-tables';
    protected $description = 'Manually create the vendor tables missing from migrations';

    public function handle()
    {
        $this->info('Fixing vendor tables...');

        if (!Schema::hasColumn('organizations', 'vendor_acceptance_timeout_minutes')) {
            Schema::table('organizations', function (Blueprint $table) {
                $table->integer('vendor_acceptance_timeout_minutes')->default(30)->after('status');
            });
            $this->info('Added vendor_acceptance_timeout_minutes to organizations.');
        } else {
            $this->info('Organizations table already has vendor_acceptance_timeout_minutes.');
        }

        if (!Schema::hasColumn('vendor', 'is_featured')) {
            Schema::table('vendor', function (Blueprint $table) {
                $table->boolean('is_featured')->default(false)->after('global_rating');
            });
            $this->info('Added is_featured to vendor.');
        } else {
            $this->info('Vendor table already has is_featured.');
        }

        if (!Schema::hasColumn('tickets', 'assigned_vendor_id')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->integer('assigned_vendor_id')->nullable()->after('response');
                $table->decimal('vendor_invoice_amount', 10, 2)->nullable()->after('assigned_vendor_id');
                $table->string('vendor_invoice_file', 255)->nullable()->after('vendor_invoice_amount');
                $table->enum('vendor_approval_status', ['pending', 'approved', 'rejected'])->nullable()->after('vendor_invoice_file');
            });
            $this->info('Added assigned_vendor_id and initial vendor fields to tickets.');
        }

        if (!Schema::hasColumn('tickets', 'vendor_category')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->string('vendor_category', 100)->nullable();
                $table->integer('vendor_broadcast_phase')->default(0);
                $table->timestamp('vendor_broadcast_started_at')->nullable();
                $table->string('vendor_service_status', 50)->nullable();
            });
            $this->info('Added vendor broadcast fields to tickets.');
        } else {
            $this->info('Tickets table already has vendor broadcast fields.');
        }

        if (!Schema::hasTable('ticket_vendor_passes')) {
            Schema::create('ticket_vendor_passes', function (Blueprint $table) {
                $table->id();
                $table->integer('ticket_id');
                $table->integer('vendor_id');
                $table->text('comment')->nullable();
                $table->timestamps();

                $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
                $table->foreign('vendor_id')->references('id')->on('vendor')->onDelete('cascade');
            });
            $this->info('Created ticket_vendor_passes table.');
        } else {
            $this->info('ticket_vendor_passes table already exists.');
        }

        if (!Schema::hasColumn('vendor_invoice', 'ticket_id')) {
            Schema::table('vendor_invoice', function (Blueprint $table) {
                $table->integer('ticket_id')->nullable()->after('vendor_id');
                $table->text('task_details')->nullable()->after('ticket_id');
                $table->integer('member_id')->nullable()->after('organization_id');
                $table->integer('resident_id')->nullable()->after('member_id');
            });
            $this->info('Added vendor_invoice fields.');
        } else {
            $this->info('Vendor invoice already has new fields.');
        }

        $this->info('All vendor tables are up to date!');
    }
}
