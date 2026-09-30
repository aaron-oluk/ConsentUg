<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Dashboard\ComplaintController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ArchivesController;

// Static Pages Routes
Route::view('/', 'index')->name('home');
Route::view('about', 'about');
Route::view('contact', 'contact');
Route::view('events', 'events');
Route::view('how-we-work', 'how-we-work');
Route::view('what-we-do', 'what-we-do');
Route::view('consumer-access', 'consumer-access');
Route::view('right-to-inclusivity', 'right-to-inclusivity');
Route::view('consumer-information', 'consumer-information');
Route::view('consumer-protection', 'consumer-protection');
Route::view('consumer-representation', 'consumer-representation');
Route::view('digital-rights', 'digital-rights');
Route::view('consumer-education', 'consumer-education');
Route::view('sustainability', 'sustainability');
Route::view('consumer-redress', 'consumer-redress');
Route::view('consumer-empowerment', 'consumer-empowerment');
Route::view('agrifood-systems', 'agrifood-systems')->name('agrifood-systems');
Route::view('sustainable-trade', 'sustainable-trade')->name('sustainable-trade');
Route::view('quality-utilities', 'quality-utilities')->name('quality-utilities');
Route::view('environment', 'environment')->name('environment');

// Authentication routes
require __DIR__.'/auth.php';

// Protected routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');

    Route::get('/profile', fn () => redirect()->route('settings'))->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('can.access:canAccessDashboard')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::middleware('can.access:canManageContent')->group(function () {
        Route::get('/dashboard/blogs', [BlogController::class, 'dashboard'])->name('dashboard.blogs');
        Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
        Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
        Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');

        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
            Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
            Route::get('/reports/{document}/download', [ReportController::class, 'download'])->name('reports.download');
            Route::delete('/reports/{document}', [ReportController::class, 'destroy'])->name('reports.destroy');
        });

        Route::resource('gallery', GalleryController::class);
    });

    Route::middleware('can.access:canManageComplaints')->group(function () {
        Route::get('/dashboard/complaints', [ComplaintController::class, 'index'])->name('dashboard.complaints.index');
        Route::get('/dashboard/complaints/{complaint}', [ComplaintController::class, 'show'])->name('dashboard.complaints.show');
        Route::delete('/dashboard/complaints/{complaint}', [ComplaintController::class, 'destroy'])->name('dashboard.complaints.destroy');
    });

    Route::middleware('can.access:canManageUsers')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Document routes used from settings/archives workflows
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
});

// Remove duplicate routes and move public blog routes outside domain constraint
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blogs.show');

Route::get('/check-blogs', function () {
    dd(App\Models\Blog::all());
});

Route::get('/test-404', function() {
    abort(404);
});

// Front-end archives page
Route::get('/archives', [ArchivesController::class, 'index'])->name('archives.index');

Route::get('/reports', [ArchivesController::class, 'reportsIndex'])->name('reports');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
