<?php

use Illuminate\Support\Facades\Route;

// Auth Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

// Home Controllers
use App\Http\Controllers\Home\HomeController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncement;
use App\Http\Controllers\Admin\MaintenanceController as AdminMaintenance;
use App\Http\Controllers\Admin\MemberController as AdminMember;
use App\Http\Controllers\Admin\StaffController as AdminStaff;
use App\Http\Controllers\Admin\ResidentController as AdminResident;
use App\Http\Controllers\Admin\VendorController as AdminVendor;
use App\Http\Controllers\Admin\PropertyController as AdminProperty;
use App\Http\Controllers\Admin\CommissionController as AdminCommission;
use App\Http\Controllers\Admin\AdvertisementController as AdminAdvertisement;
use App\Http\Controllers\Admin\DonorController as AdminDonor;
use App\Http\Controllers\Admin\SponsorController as AdminSponsor;
use App\Http\Controllers\Admin\EventController as AdminEvent;
use App\Http\Controllers\Admin\GalleryController as AdminGallery;
use App\Http\Controllers\Admin\HelpdeskController as AdminHelpdesk;
use App\Http\Controllers\Admin\ProfileController as AdminProfile;

// Member Controllers
use App\Http\Controllers\Member\DashboardController as MemberDashboard;
use App\Http\Controllers\Member\AnnouncementController as MemberAnnouncement;
use App\Http\Controllers\Member\MaintenanceController as MemberMaintenance;
use App\Http\Controllers\Member\HelpdeskController as MemberHelpdesk;

// Staff Controllers
use App\Http\Controllers\Staff\DashboardController as StaffDashboard;

// SuperAdmin Controllers
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\SuperAdmin\MenuConfigController as SuperAdminMenuConfig;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/members', [HomeController::class, 'members'])->name('home.members');
Route::get('/events', [HomeController::class, 'events'])->name('home.events');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('home.gallery');
Route::get('/donors', [HomeController::class, 'donors'])->name('home.donors');
Route::get('/sponsors', [HomeController::class, 'sponsors'])->name('home.sponsors');
Route::get('/notices', [HomeController::class, 'notices'])->name('home.notices');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post')->middleware('throttle:6,1');
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

/*
|--------------------------------------------------------------------------
| Admin Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth.session', 'role:admin,super_admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Vendor Approvals
    Route::get('/vendors/approvals', [\App\Http\Controllers\Admin\VendorApprovalController::class, 'index'])->name('vendors.approvals.index');
    Route::post('/vendors/approvals/{id}/approve', [\App\Http\Controllers\Admin\VendorApprovalController::class, 'approve'])->name('vendors.approvals.approve');
    Route::post('/vendors/approvals/{id}/reject', [\App\Http\Controllers\Admin\VendorApprovalController::class, 'reject'])->name('vendors.approvals.reject');

    // Admins (Sub-Admins)
    Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class);

    // Announcements
    Route::get('/announcements', [AdminAnnouncement::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create', [AdminAnnouncement::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AdminAnnouncement::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{id}/edit', [AdminAnnouncement::class, 'edit'])->name('announcements.edit');
    Route::put('/announcements/{id}', [AdminAnnouncement::class, 'update'])->name('announcements.update');
    Route::delete('/announcements/{id}', [AdminAnnouncement::class, 'destroy'])->name('announcements.destroy');

    // Maintenance
    Route::get('/maintenance', [AdminMaintenance::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/create', [AdminMaintenance::class, 'create'])->name('maintenance.create');
    Route::post('/maintenance', [AdminMaintenance::class, 'store'])->name('maintenance.store');
    Route::get('/maintenance/{id}', [AdminMaintenance::class, 'show'])->name('maintenance.show');
    Route::post('/maintenance/{id}/pay', [AdminMaintenance::class, 'markPaid'])->name('maintenance.pay');
    Route::delete('/maintenance/{id}', [AdminMaintenance::class, 'destroy'])->name('maintenance.destroy');

    // Members
    Route::resource('members', AdminMember::class);

    // Staff
    Route::resource('staff', AdminStaff::class);

    // Residents
    Route::resource('residents', AdminResident::class);

    // Vendors
    Route::resource('vendors', AdminVendor::class);

    // Commissions
    Route::get('/commissions', [AdminCommission::class, 'index'])->name('commissions.index');
    Route::post('/commissions/{id}/pay', [AdminCommission::class, 'markPaid'])->name('commissions.pay');

    // Vendor Advertisements
    Route::get('/advertisements', [AdminAdvertisement::class, 'index'])->name('advertisements.index');
    Route::post('/advertisements/{id}/approve', [AdminAdvertisement::class, 'approve'])->name('advertisements.approve');
    Route::post('/advertisements/{id}/reject', [AdminAdvertisement::class, 'reject'])->name('advertisements.reject');

    // Properties
    Route::resource('properties', AdminProperty::class);

    // Donors
    Route::resource('donors', AdminDonor::class);

    // Sponsors
    Route::resource('sponsors', AdminSponsor::class);

    // Events
    Route::resource('events', AdminEvent::class);

    // Gallery
    Route::get('/gallery', [AdminGallery::class, 'index'])->name('gallery.index');
    Route::get('/gallery/create', [AdminGallery::class, 'create'])->name('gallery.create');
    Route::post('/gallery', [AdminGallery::class, 'store'])->name('gallery.store');
    Route::delete('/gallery/{id}', [AdminGallery::class, 'destroy'])->name('gallery.destroy');

    // Helpdesk
    Route::get('/helpdesk', [AdminHelpdesk::class, 'index'])->name('helpdesk.index');
    Route::get('/helpdesk/{id}', [AdminHelpdesk::class, 'show'])->name('helpdesk.show');
    Route::post('/helpdesk/{id}/respond', [AdminHelpdesk::class, 'respond'])->name('helpdesk.respond');

    // Profile
    // Profile Routes have been moved to global level

    // Community Network Approvals (Stage 2)
    Route::get('/community-approvals', [\App\Http\Controllers\Admin\CommunityApprovalController::class, 'index'])->name('community.approvals');
    Route::post('/community-approvals/bulk', [\App\Http\Controllers\Admin\CommunityApprovalController::class, 'bulkAction'])->name('community.bulk');
    Route::post('/community-approvals/{id}/approve', [\App\Http\Controllers\Admin\CommunityApprovalController::class, 'approve'])->name('community.approve');
    Route::post('/community-approvals/{id}/reject', [\App\Http\Controllers\Admin\CommunityApprovalController::class, 'reject'])->name('community.reject');

    // SOLID Approvals & Settings (Stage 2)
    Route::get('/solid-approvals', [\App\Http\Controllers\Admin\SolidApprovalController::class, 'index'])->name('solid.index');
    Route::post('/solid-approvals/{id}/approve', [\App\Http\Controllers\Admin\SolidApprovalController::class, 'approve'])->name('solid.approve');
    Route::post('/solid-approvals/{id}/reject', [\App\Http\Controllers\Admin\SolidApprovalController::class, 'reject'])->name('solid.reject');
    Route::get('/solid-settings', [\App\Http\Controllers\Admin\SolidApprovalController::class, 'settings'])->name('solid.settings');
    Route::put('/solid-settings', [\App\Http\Controllers\Admin\SolidApprovalController::class, 'updateSettings'])->name('solid.settings.update');
});

/*
|--------------------------------------------------------------------------
| Member Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('member')->middleware(['auth.session', 'role:member'])->name('member.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Member\DashboardController::class, 'index'])->name('dashboard');
    
    // Vendor Directory & Reviews
    Route::get('/vendors/directory', [\App\Http\Controllers\Member\VendorDirectoryController::class, 'index'])->name('vendors.directory');
    Route::get('/vendors/directory/{id}', [\App\Http\Controllers\Member\VendorDirectoryController::class, 'show'])->name('vendors.show');
    Route::post('/vendors/{id}/review', [\App\Http\Controllers\Member\VendorReviewController::class, 'store'])->name('vendors.review.store');
    
    // Vendor Voting
    Route::get('/vendors/vote', [\App\Http\Controllers\Member\VendorVoteController::class, 'index'])->name('vendors.vote.index');

    Route::get('/announcements', [MemberAnnouncement::class, 'index'])->name('announcements.index');

    Route::get('/maintenance', [MemberMaintenance::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/{id}', [MemberMaintenance::class, 'show'])->name('maintenance.show');

    Route::get('/helpdesk', [MemberHelpdesk::class, 'index'])->name('helpdesk.index');
    Route::get('/helpdesk/create', [MemberHelpdesk::class, 'create'])->name('helpdesk.create');
    Route::post('/helpdesk', [MemberHelpdesk::class, 'store'])->name('helpdesk.store');
    Route::get('/helpdesk/{id}', [MemberHelpdesk::class, 'show'])->name('helpdesk.show');
    Route::post('/helpdesk/{id}/reply', [MemberHelpdesk::class, 'reply'])->name('helpdesk.reply');

    // Community Network
    Route::get('/community', [\App\Http\Controllers\Member\CommunityFeedController::class, 'index'])->name('community.feed');
    Route::get('/community/create', [\App\Http\Controllers\Member\CommunityFeedController::class, 'create'])->name('community.create');
    Route::post('/community', [\App\Http\Controllers\Member\CommunityFeedController::class, 'store'])->name('community.store');
    Route::get('/community/my-posts', [\App\Http\Controllers\Member\CommunityFeedController::class, 'myPosts'])->name('community.my_posts');

    // SOLID Approvals
    Route::get('/solid-approvals', [\App\Http\Controllers\Member\SolidApprovalController::class, 'index'])->name('solid.index');
    Route::get('/solid-approvals/create', [\App\Http\Controllers\Member\SolidApprovalController::class, 'create'])->name('solid.create');
    Route::post('/solid-approvals', [\App\Http\Controllers\Member\SolidApprovalController::class, 'store'])->name('solid.store');
});

/*
|--------------------------------------------------------------------------
| Staff Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('staff')->middleware(['auth.session', 'role:staff'])->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffDashboard::class, 'index'])->name('dashboard');

    // Vendor Proposal
    Route::get('/vendors/alignments', [\App\Http\Controllers\Staff\VendorAlignmentController::class, 'index'])->name('vendors.alignments.index');
    Route::post('/vendors/alignments/propose', [\App\Http\Controllers\Staff\VendorAlignmentController::class, 'propose'])->name('vendors.alignments.propose');
    Route::post('/vendors/alignments/{id}/start-voting', [\App\Http\Controllers\Staff\VendorAlignmentController::class, 'startVoting'])->name('vendors.alignments.start_voting');

    // Helpdesk & Tickets Management (Staff CRUD)
    Route::get('/helpdesk', [\App\Http\Controllers\Staff\HelpdeskController::class, 'index'])->name('helpdesk.index');
    Route::get('/helpdesk/{id}/edit', [\App\Http\Controllers\Staff\HelpdeskController::class, 'edit'])->name('helpdesk.edit');
    Route::put('/helpdesk/{id}', [\App\Http\Controllers\Staff\HelpdeskController::class, 'update'])->name('helpdesk.update');
    Route::post('/helpdesk/{id}/reply', [\App\Http\Controllers\Staff\HelpdeskController::class, 'reply'])->name('helpdesk.reply');
    
    // Properties & Units Management
    Route::get('/properties', [\App\Http\Controllers\Staff\PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/create', [\App\Http\Controllers\Staff\PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [\App\Http\Controllers\Staff\PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{id}/edit', [\App\Http\Controllers\Staff\PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{id}', [\App\Http\Controllers\Staff\PropertyController::class, 'update'])->name('properties.update');
    Route::get('/properties/bulk-upload', [\App\Http\Controllers\Staff\PropertyController::class, 'bulkUploadForm'])->name('properties.bulk_upload');
    Route::post('/properties/bulk-upload', [\App\Http\Controllers\Staff\PropertyController::class, 'processBulkUpload'])->name('properties.process_bulk_upload');

    // Members Management
    Route::get('/members', [\App\Http\Controllers\Staff\MemberController::class, 'index'])->name('members.index');
    Route::get('/members/create', [\App\Http\Controllers\Staff\MemberController::class, 'create'])->name('members.create');
    Route::post('/members', [\App\Http\Controllers\Staff\MemberController::class, 'store'])->name('members.store');
    Route::get('/members/{id}/edit', [\App\Http\Controllers\Staff\MemberController::class, 'edit'])->name('members.edit');
    Route::put('/members/{id}', [\App\Http\Controllers\Staff\MemberController::class, 'update'])->name('members.update');

    // Residents (Tenants) Management
    Route::get('/residents', [\App\Http\Controllers\Staff\ResidentController::class, 'index'])->name('residents.index');
    Route::get('/residents/create', [\App\Http\Controllers\Staff\ResidentController::class, 'create'])->name('residents.create');
    Route::post('/residents', [\App\Http\Controllers\Staff\ResidentController::class, 'store'])->name('residents.store');
    Route::get('/residents/{id}/edit', [\App\Http\Controllers\Staff\ResidentController::class, 'edit'])->name('residents.edit');
    Route::put('/residents/{id}', [\App\Http\Controllers\Staff\ResidentController::class, 'update'])->name('residents.update');

    // Community Network Moderation (Stage 1)
    Route::get('/community-moderation', [\App\Http\Controllers\Staff\CommunityModerationController::class, 'index'])->name('community.moderation');
    Route::post('/community-moderation/bulk', [\App\Http\Controllers\Staff\CommunityModerationController::class, 'bulkAction'])->name('community.bulk');
    Route::post('/community-moderation/{id}/approve', [\App\Http\Controllers\Staff\CommunityModerationController::class, 'approve'])->name('community.approve');
    Route::post('/community-moderation/{id}/reject', [\App\Http\Controllers\Staff\CommunityModerationController::class, 'reject'])->name('community.reject');

    // SOLID Approvals Verification (Stage 1)
    Route::get('/solid-approvals', [\App\Http\Controllers\Staff\SolidApprovalController::class, 'index'])->name('solid.index');
    Route::post('/solid-approvals/{id}/approve', [\App\Http\Controllers\Staff\SolidApprovalController::class, 'approve'])->name('solid.approve');
    Route::post('/solid-approvals/{id}/reject', [\App\Http\Controllers\Staff\SolidApprovalController::class, 'reject'])->name('solid.reject');
});

// Global Profile Routes (Dynamic for all roles)
Route::middleware(['auth.session'])->group(function () {
    Route::get('/super-admin/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('super_admin.profile');
    Route::put('/super-admin/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('super_admin.profile.update');

    Route::get('/admin/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('admin.profile');
    Route::put('/admin/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('admin.profile.update');
    
    Route::get('/staff/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('staff.profile');
    Route::put('/staff/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('staff.profile.update');
    
    Route::get('/member/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('member.profile');
    Route::put('/member/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('member.profile.update');
    
    Route::get('/resident/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('resident.profile');
    Route::put('/resident/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('resident.profile.update');
    
    Route::get('/vendor/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('vendor.profile');
    Route::put('/vendor/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('vendor.profile.update');

    // Mobile Access Routes (Available to all logged-in users)
    Route::get('/profile/mobile-access', [\App\Http\Controllers\ProfileController::class, 'mobileAccess'])->name('profile.mobile_access');
    Route::post('/profile/generate-qr', [\App\Http\Controllers\ProfileController::class, 'generateQr'])->name('profile.generate_qr');
});

/*
|--------------------------------------------------------------------------
| Vendor Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('vendor')->middleware(['auth.session', 'role:vendor'])->name('vendor.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Vendor\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/advertisements', [\App\Http\Controllers\Vendor\AdvertisementController::class, 'index'])->name('advertisements.index');
    Route::post('/advertisements', [\App\Http\Controllers\Vendor\AdvertisementController::class, 'store'])->name('advertisements.store');
    
    // Services
    Route::get('/services', [\App\Http\Controllers\Vendor\ServiceRequestController::class, 'index'])->name('services.index');
    Route::post('/services/{id}/accept', [\App\Http\Controllers\Vendor\ServiceRequestController::class, 'accept'])->name('services.accept');
    Route::post('/services/{id}/pass', [\App\Http\Controllers\Vendor\ServiceRequestController::class, 'pass'])->name('services.pass');
    Route::post('/services/{id}/invoice', [\App\Http\Controllers\Vendor\ServiceRequestController::class, 'generateInvoice'])->name('services.invoice');
    Route::post('/services/{id}/complete', [\App\Http\Controllers\Vendor\ServiceRequestController::class, 'complete'])->name('services.complete');

    // Reviews
    Route::get('/reviews', [\App\Http\Controllers\Vendor\ReviewController::class, 'index'])->name('reviews.index');
});

/*
|--------------------------------------------------------------------------
| Super Admin Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('super-admin')->middleware(['auth.session', 'role:super_admin'])->name('super_admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/organizations/{id}/manage', [\App\Http\Controllers\SuperAdmin\DashboardController::class, 'manageOrg'])->name('org.manage');
    Route::post('/organizations/stop-managing', [\App\Http\Controllers\SuperAdmin\DashboardController::class, 'stopManaging'])->name('org.stop_managing');
    Route::post('/organizations/{id}/approve', [\App\Http\Controllers\SuperAdmin\DashboardController::class, 'approveOrg'])->name('org.approve');
    Route::post('/organizations/{id}/reject', [\App\Http\Controllers\SuperAdmin\DashboardController::class, 'rejectOrg'])->name('org.reject');

    // Menu Configuration
    Route::get('/menu-config', [SuperAdminMenuConfig::class, 'index'])->name('menu_config.index');
    Route::get('/menu-config/bulk-edit', [SuperAdminMenuConfig::class, 'bulkEdit'])->name('menu_config.bulk_edit');
    Route::put('/menu-config/bulk-update', [SuperAdminMenuConfig::class, 'bulkUpdate'])->name('menu_config.bulk_update');
    Route::get('/menu-config/{id}/edit', [SuperAdminMenuConfig::class, 'edit'])->name('menu_config.edit');
    Route::put('/menu-config/{id}', [SuperAdminMenuConfig::class, 'update'])->name('menu_config.update');
    Route::get('/menu-config/presets/{type}', [SuperAdminMenuConfig::class, 'presetMenus'])->name('menu_config.presets');

    // Theme Builder
    Route::prefix('theme-builder')->name('theme_builder.')->group(function () {
        Route::get('/', [\App\Http\Controllers\SuperAdmin\ThemeBuilderController::class, 'index'])->name('index');
        Route::get('/presets', [\App\Http\Controllers\SuperAdmin\ThemeBuilderController::class, 'presets'])->name('presets');
        Route::get('/{orgId}/edit', [\App\Http\Controllers\SuperAdmin\ThemeBuilderController::class, 'edit'])->name('edit');
        Route::post('/{orgId}', [\App\Http\Controllers\SuperAdmin\ThemeBuilderController::class, 'store'])->name('store');
        Route::post('/{orgId}/preview', [\App\Http\Controllers\SuperAdmin\ThemeBuilderController::class, 'preview'])->name('preview');
        Route::post('/{orgId}/publish', [\App\Http\Controllers\SuperAdmin\ThemeBuilderController::class, 'publish'])->name('publish');
        Route::post('/{orgId}/rollback', [\App\Http\Controllers\SuperAdmin\ThemeBuilderController::class, 'rollback'])->name('rollback');
        Route::post('/{orgId}/apply-preset', [\App\Http\Controllers\SuperAdmin\ThemeBuilderController::class, 'applyPreset'])->name('apply_preset');
    });
});
