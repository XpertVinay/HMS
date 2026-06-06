<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creates all base application tables that were previously only defined
 * in database/schema/mysql-schema.sql. This migration ensures that
 * `php artisan migrate:fresh` works without needing the schema dump.
 *
 * Tables are ordered so that parent tables are created before children
 * that reference them via foreign keys.
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── Organizations (referenced by almost every other table) ───────
        Schema::create('organizations', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name', 255);
            $table->text('address');
            $table->string('registration_code', 100)->unique();
            $table->string('subdomain', 100)->unique();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->string('logo_url', 255)->nullable();
            $table->string('primary_color', 20)->nullable();
            $table->string('secondary_color', 20)->nullable();
        });

        // ── Super Admin ──────────────────────────────────────────────────
        Schema::create('super_admin', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->dateTime('created_at')->nullable()->useCurrent();
        });

        // ── Admin ────────────────────────────────────────────────────────
        Schema::create('admin', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('username', 50)->unique();
            $table->string('email', 50)->unique();
            $table->string('password', 255);
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->string('mobile_number', 20)->nullable();
            $table->string('rwa_election_copy', 255)->nullable();
            $table->string('social_registration_number', 100)->nullable();
            $table->boolean('is_id_verified')->default(false);
            $table->integer('organization_id')->default(1);
            $table->enum('role', ['admin', 'sub-admin'])->default('admin');

            $table->foreign('organization_id', 'fk_admin_org')
                  ->references('id')->on('organizations')->cascadeOnDelete();
        });

        // ── Staff ────────────────────────────────────────────────────────
        Schema::create('staff', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('username', 50)->unique();
            $table->string('email', 50)->unique();
            $table->string('password', 255);
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->string('mobile_number', 20)->nullable();
            $table->string('employment_contract', 255)->nullable();
            $table->boolean('is_id_verified')->default(false);
            $table->integer('organization_id')->default(1);

            $table->foreign('organization_id', 'fk_staff_org')
                  ->references('id')->on('organizations')->cascadeOnDelete();
        });

        // ── Member ───────────────────────────────────────────────────────
        Schema::create('member', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('username', 50)->unique();
            $table->string('email', 50)->unique();
            $table->string('password', 255);
            $table->string('address', 255);
            $table->string('phone', 20)->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->string('share_certificate', 255)->nullable();
            $table->boolean('is_deed_verified_staff')->default(false);
            $table->boolean('is_deed_verified_admin')->default(false);
            $table->integer('organization_id')->default(1);

            $table->foreign('organization_id', 'fk_member_org')
                  ->references('id')->on('organizations')->cascadeOnDelete();
        });

        // ── Resident ─────────────────────────────────────────────────────
        Schema::create('resident', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('username', 50)->unique();
            $table->string('email', 50)->unique();
            $table->string('password', 255);
            $table->string('address', 255);
            $table->string('mobile_number', 20)->nullable();
            $table->integer('organization_id')->nullable();
            $table->string('owner_noc', 255)->nullable();
            $table->boolean('is_rent_agreement_verified_staff')->default(false);
            $table->boolean('is_rent_agreement_verified_admin')->default(false);
            $table->dateTime('created_at')->nullable()->useCurrent();
        });

        // ── Property (references member + resident) ──────────────────────
        Schema::create('property', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('address', 255)->unique();
            $table->string('type', 50)->default('Flat');
            $table->integer('owner_id')->nullable();
            $table->integer('organization_id')->nullable();
            $table->integer('resident_id')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();

            $table->index('owner_id');
            $table->index('resident_id');
            $table->foreign('owner_id', 'property_ibfk_1')
                  ->references('id')->on('member')->nullOnDelete();
            $table->foreign('resident_id', 'property_ibfk_2')
                  ->references('id')->on('resident')->nullOnDelete();
        });

        // ── Vendor ───────────────────────────────────────────────────────
        Schema::create('vendor', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('business_name', 100)->unique();
            $table->string('email', 50)->unique();
            $table->string('password', 255);
            $table->string('business_registration', 255)->nullable();
            $table->integer('organization_id')->nullable();
            $table->text('bank_account_details')->nullable();
            $table->boolean('is_gst_verified_staff')->default(false);
            $table->boolean('is_gst_verified_admin')->default(false);
            $table->dateTime('created_at')->nullable()->useCurrent();
        });

        // ── Vendor Invoice ───────────────────────────────────────────────
        Schema::create('vendor_invoice', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('vendor_id');
            $table->string('invoice_file', 255);
            $table->double('amount');
            $table->integer('organization_id')->nullable();
            $table->string('status', 20)->default('Pending');
            $table->dateTime('created_at')->nullable()->useCurrent();

            $table->index('vendor_id');
            $table->foreign('vendor_id', 'vendor_invoice_ibfk_1')
                  ->references('id')->on('vendor')->cascadeOnDelete();
        });

        // ── Announcement ─────────────────────────────────────────────────
        Schema::create('announcement', function (Blueprint $table) {
            $table->integer('announcement_id')->autoIncrement();
            $table->string('announcement_subject', 250);
            $table->text('announcement_text');
            $table->integer('announcement_status');
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->integer('organization_id')->default(1);

            $table->foreign('organization_id', 'fk_announcement_org')
                  ->references('id')->on('organizations')->cascadeOnDelete();
        });

        // ── Donors ───────────────────────────────────────────────────────
        Schema::create('donors', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name', 100);
            $table->string('email', 100)->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('donation_date');
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->integer('organization_id')->default(1);

            $table->foreign('organization_id', 'fk_donors_org')
                  ->references('id')->on('organizations')->cascadeOnDelete();
        });

        // ── Events ───────────────────────────────────────────────────────
        Schema::create('events', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->date('event_date');
            $table->time('event_time')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->integer('organization_id')->default(1);

            $table->foreign('organization_id', 'fk_events_org')
                  ->references('id')->on('organizations')->cascadeOnDelete();
        });

        // ── Gallery ──────────────────────────────────────────────────────
        Schema::create('gallery', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('title', 150);
            $table->string('image_url', 255);
            $table->text('description')->nullable();
            $table->dateTime('uploaded_at')->nullable()->useCurrent();
            $table->integer('organization_id')->default(1);

            $table->foreign('organization_id', 'fk_gallery_org')
                  ->references('id')->on('organizations')->cascadeOnDelete();
        });

        // ── Maintenance ──────────────────────────────────────────────────
        Schema::create('maintenance', function (Blueprint $table) {
            $table->integer('id');
            $table->dateTime('billing_date')->useCurrent();
            $table->integer('member_id');
            $table->boolean('status')->default(false)->comment('0=pending,1=paid');
            $table->double('total_amount');
            $table->double('amount_payed');
            $table->double('amount_change');
            $table->string('invoice', 50);
            $table->integer('organization_id')->default(1);

            $table->foreign('organization_id', 'fk_billing_org')
                  ->references('id')->on('organizations')->cascadeOnDelete();
        });

        // ── Maintenance Items ────────────────────────────────────────────
        Schema::create('maintenance_items', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('maintenance_id');
            $table->tinyInteger('type')->comment('1=block rent, 2=electricity, 3=water');
            $table->integer('reading');
            $table->integer('consumption');
            $table->double('rate');
            $table->integer('previous_reading');
            $table->integer('previous_consumption');
            $table->double('amount');
            $table->double('previous_amount');
            $table->integer('organization_id')->default(1);

            $table->foreign('organization_id', 'fk_bills_org')
                  ->references('id')->on('organizations')->cascadeOnDelete();
        });

        // ── Registry (visitor log) ───────────────────────────────────────
        Schema::create('registry', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('visitor_name', 50);
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->integer('host_id')->nullable();
            $table->string('visitor_contact', 20)->nullable();
            $table->string('purpose', 255)->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Completed'])->default('Pending');
            $table->dateTime('out_time')->nullable();
            $table->integer('organization_id')->default(1);

            $table->foreign('host_id', 'fk_registry_host')
                  ->references('id')->on('member')->nullOnDelete();
            $table->foreign('organization_id', 'fk_registry_org')
                  ->references('id')->on('organizations')->cascadeOnDelete();
        });

        // ── Sponsors ─────────────────────────────────────────────────────
        Schema::create('sponsors', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name', 150);
            $table->string('logo_url', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('website_url', 255)->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->integer('organization_id')->default(1);

            $table->foreign('organization_id', 'fk_sponsors_org')
                  ->references('id')->on('organizations')->cascadeOnDelete();
        });

        // ── Tickets ──────────────────────────────────────────────────────
        Schema::create('tickets', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('organization_id')->default(1);
            $table->integer('member_id');
            $table->string('subject', 255);
            $table->text('description');
            $table->string('category', 100);
            $table->enum('status', ['pending', 'in_progress', 'resolved'])->default('pending');
            $table->text('response')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();

            $table->foreign('organization_id', 'fk_tickets_org')
                  ->references('id')->on('organizations')->cascadeOnDelete();
            $table->foreign('member_id', 'fk_tickets_member')
                  ->references('id')->on('member')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        // Drop in reverse order (children before parents)
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('sponsors');
        Schema::dropIfExists('registry');
        Schema::dropIfExists('maintenance_items');
        Schema::dropIfExists('maintenance');
        Schema::dropIfExists('gallery');
        Schema::dropIfExists('events');
        Schema::dropIfExists('donors');
        Schema::dropIfExists('announcement');
        Schema::dropIfExists('vendor_invoice');
        Schema::dropIfExists('vendor');
        Schema::dropIfExists('property');
        Schema::dropIfExists('resident');
        Schema::dropIfExists('member');
        Schema::dropIfExists('staff');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('super_admin');
        Schema::dropIfExists('organizations');
    }
};
