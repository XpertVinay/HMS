<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creates the three core tables for the White-Label Theme Engine:
 *
 *  1. tenant_domains   – maps custom domains/subdomains → organizations
 *  2. tenant_themes    – full theme configuration per organization
 *  3. theme_presets    – reusable theme templates (system + custom)
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Tenant Domains ────────────────────────────────────────────
        Schema::create('tenant_domains', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->string('domain', 255)->nullable()->comment('Full custom domain e.g. myrwa.com');
            $table->string('subdomain', 100)->nullable()->comment('Subdomain prefix e.g. green-valley');
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->enum('ssl_status', ['pending', 'active', 'expired', 'failed'])->default('pending');
            $table->timestamps();

            $table->foreign('organization_id')
                  ->references('id')->on('organizations')
                  ->cascadeOnDelete();

            $table->unique('domain');
            $table->unique('subdomain');
            $table->index(['organization_id', 'is_primary']);
        });

        // ── 2. Tenant Themes ─────────────────────────────────────────────
        Schema::create('tenant_themes', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->string('theme_slug', 100)->default('default');
            $table->string('theme_name', 150)->default('Default Theme');
            $table->boolean('is_active')->default(true);

            // ── Core Colors ──
            $table->string('primary_color', 30)->nullable();
            $table->string('secondary_color', 30)->nullable();
            $table->string('accent_color', 30)->nullable();

            // ── Background Colors ──
            $table->string('background_primary', 30)->nullable();
            $table->string('background_secondary', 30)->nullable();

            // ── Text Colors ──
            $table->string('text_primary', 30)->nullable();
            $table->string('text_secondary', 30)->nullable();

            // ── Dark Mode Colors ──
            $table->string('dark_bg_primary', 30)->nullable();
            $table->string('dark_bg_secondary', 30)->nullable();
            $table->string('dark_text_primary', 30)->nullable();
            $table->string('dark_text_secondary', 30)->nullable();

            // ── Typography ──
            $table->string('font_primary', 100)->nullable();
            $table->string('font_secondary', 100)->nullable();
            $table->string('font_size_base', 20)->nullable();

            // ── Spacing & Borders ──
            $table->string('border_radius_sm', 20)->nullable();
            $table->string('border_radius_md', 20)->nullable();
            $table->string('border_radius_lg', 20)->nullable();
            $table->string('shadow_sm', 255)->nullable();
            $table->string('shadow_md', 255)->nullable();
            $table->string('shadow_lg', 255)->nullable();

            // ── Assets ──
            $table->string('logo_light', 500)->nullable()->comment('Logo for light backgrounds');
            $table->string('logo_dark', 500)->nullable()->comment('Logo for dark backgrounds');
            $table->string('favicon', 500)->nullable();
            $table->string('app_icon', 500)->nullable();
            $table->string('splash_image', 500)->nullable();
            $table->string('email_header_image', 500)->nullable();
            $table->string('email_footer_image', 500)->nullable();

            // ── Theme Mode ──
            $table->enum('theme_mode', ['light', 'dark', 'auto', 'custom'])->default('light');

            // ── Component Overrides (JSON) ──
            $table->json('component_tokens')->nullable()->comment('Per-component CSS variable overrides');

            // ── Custom CSS ──
            $table->text('custom_css')->nullable()->comment('Tenant-specific CSS (sanitized)');

            // ── Versioning ──
            $table->string('theme_version', 20)->default('1.0.0');
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('organization_id')
                  ->references('id')->on('organizations')
                  ->cascadeOnDelete();

            $table->index(['organization_id', 'is_active']);
            $table->unique(['organization_id', 'theme_slug']);
        });

        // ── 3. Theme Presets ─────────────────────────────────────────────
        Schema::create('theme_presets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->json('theme_data')->comment('Full theme configuration as JSON');
            $table->string('preview_image', 500)->nullable();
            $table->boolean('is_system')->default(false)->comment('System presets cannot be deleted');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('theme_presets');
        Schema::dropIfExists('tenant_themes');
        Schema::dropIfExists('tenant_domains');
    }
};
