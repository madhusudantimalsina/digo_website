<?php

use Illuminate\Support\Facades\Route;

// AUTH + ADMIN
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPageController; // <- admin pages controller
use App\Http\Controllers\Admin\NoticeController as AdminNoticeController;
use App\Http\Controllers\Admin\FinancialReportController as AdminFinancialReportController;
use App\Http\Controllers\Admin\GalleryAlbumController;
use App\Http\Controllers\Admin\GalleryImageController;
use App\Http\Controllers\Admin\FormController as AdminFormController;
use App\Http\Controllers\Admin\FormSubmissionController;

// PUBLIC
use App\Http\Controllers\Public\PageController as PublicPageController;
use App\Http\Controllers\Public\NoticeController as PublicNoticeController;
use App\Http\Controllers\Public\FinancialController as PublicFinancialController;
use App\Http\Controllers\Public\GalleryController as PublicGalleryController;
use App\Http\Controllers\Public\FormController as PublicFormController;

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/

// Show admin login form
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])
    ->name('admin.login');

// Handle admin login submit
Route::post('/admin/login', [AdminLoginController::class, 'login'])
    ->name('admin.login.submit');

// Handle admin logout
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes (auth:admin)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Pages management (Home, About, Services, Contact, etc.)
        Route::resource('pages', AdminPageController::class);

        // Notices & Announcements
        Route::resource('notices', AdminNoticeController::class);

        // Financial Reports
        Route::resource('financial-reports', AdminFinancialReportController::class);

        // Gallery: Albums
        Route::resource('albums', GalleryAlbumController::class);

        // Gallery Images (only store & destroy)
        Route::post('images', [GalleryImageController::class, 'store'])
            ->name('images.store');

        Route::delete('images/{image}', [GalleryImageController::class, 'destroy'])
            ->name('images.destroy');

        // Forms (membership, loan request, share, feedback etc.)
        Route::resource('forms', AdminFormController::class);

        // Form submissions (user-submitted data)
        Route::get('form-submissions', [FormSubmissionController::class, 'index'])
            ->name('form-submissions.index');

        Route::get('form-submissions/{id}', [FormSubmissionController::class, 'show'])
            ->name('form-submissions.show');

        Route::post('form-submissions/{id}/status', [FormSubmissionController::class, 'updateStatus'])
            ->name('form-submissions.status');
    });

/*
|--------------------------------------------------------------------------
| Public Routes (no login)
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', [PublicPageController::class, 'home'])
    ->name('home');

// Static pages (About, Services, Contact, Team, etc.)
Route::get('/page/{slug}', [PublicPageController::class, 'show'])
    ->name('page.show');

// Notices (list + detail)
Route::get('/notices', [PublicNoticeController::class, 'index'])
    ->name('notices.index');

Route::get('/notices/{id}', [PublicNoticeController::class, 'show'])
    ->name('notices.show');

// Financial reports listing
Route::get('/financial-reports', [PublicFinancialController::class, 'index'])
    ->name('financial.index');

// Single financial report detail
Route::get('/financial-reports/{report}', [PublicFinancialController::class, 'show'])
    ->name('financial.show');

// Public gallery (albums + album detail)
Route::get('/gallery', [PublicGalleryController::class, 'index'])
    ->name('gallery.index');

Route::get('/gallery/{album}', [PublicGalleryController::class, 'show'])
    ->name('gallery.show');

// Generic forms (membership, loan, etc.)
Route::get('/forms/{slug}', [PublicFormController::class, 'show'])
    ->name('forms.show');

Route::post('/forms/{slug}', [PublicFormController::class, 'submit'])
    ->name('forms.submit');

// Contact page (user side)
Route::get('/contact', [PublicFormController::class, 'contact'])
    ->name('contact');

Route::post('/contact', [PublicFormController::class, 'submitContact'])
    ->name('contact.submit');
