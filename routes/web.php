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

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
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
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

/*
|--------------------------------------------------------------------------
| Admin Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth.session', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

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
    Route::get('/profile', [AdminProfile::class, 'index'])->name('profile');
    Route::put('/profile', [AdminProfile::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Member Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('member')->middleware(['auth.session', 'role:member'])->name('member.')->group(function () {
    Route::get('/dashboard', [MemberDashboard::class, 'index'])->name('dashboard');
    Route::get('/announcements', [MemberAnnouncement::class, 'index'])->name('announcements.index');

    Route::get('/maintenance', [MemberMaintenance::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/{id}', [MemberMaintenance::class, 'show'])->name('maintenance.show');

    Route::get('/helpdesk', [MemberHelpdesk::class, 'index'])->name('helpdesk.index');
    Route::get('/helpdesk/create', [MemberHelpdesk::class, 'create'])->name('helpdesk.create');
    Route::post('/helpdesk', [MemberHelpdesk::class, 'store'])->name('helpdesk.store');
    Route::get('/helpdesk/{id}', [MemberHelpdesk::class, 'show'])->name('helpdesk.show');
});

/*
|--------------------------------------------------------------------------
| Staff Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('staff')->middleware(['auth.session', 'role:staff'])->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffDashboard::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Super Admin Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('super-admin')->middleware(['auth.session', 'role:super_admin'])->name('super_admin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboard::class, 'index'])->name('dashboard');
    Route::post('/organizations/{id}/approve', [SuperAdminDashboard::class, 'approveOrg'])->name('org.approve');
    Route::post('/organizations/{id}/reject', [SuperAdminDashboard::class, 'rejectOrg'])->name('org.reject');
});
