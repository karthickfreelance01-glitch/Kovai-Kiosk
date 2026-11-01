<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\HeroSliderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{category:slug}', [ProductController::class, 'category'])->name('products.category');
Route::get('/products/{category:slug}/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Enquiry
Route::get('/enquiry', [EnquiryController::class, 'create'])->name('enquiry.create');
Route::post('/enquiry', [EnquiryController::class, 'store'])->name('enquiry.store');
Route::get('/enquiry/success/{reference}', [EnquiryController::class, 'success'])->name('enquiry.success');

// AJAX
Route::get('/api/products-by-category', [EnquiryController::class, 'getProducts'])->name('api.products');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Admin Auth (not protected by admin middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin Protected Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', CategoryController::class);
    Route::post('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    // Products
    Route::resource('products', AdminProductController::class);
    Route::post('/products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::delete('/products/images/{image}', [AdminProductController::class, 'deleteImage'])->name('products.images.delete');
    Route::post('/products/images/{image}/set-primary', [AdminProductController::class, 'setPrimaryImage'])->name('products.images.set-primary');

    // Enquiries
    Route::get('/enquiries', [AdminEnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('/enquiries/export', [AdminEnquiryController::class, 'export'])->name('enquiries.export');
    Route::get('/enquiries/{enquiry}', [AdminEnquiryController::class, 'show'])->name('enquiries.show');
    Route::post('/enquiries/{enquiry}/status', [AdminEnquiryController::class, 'updateStatus'])->name('enquiries.update-status');
    Route::post('/enquiries/{enquiry}/notes', [AdminEnquiryController::class, 'addNote'])->name('enquiries.add-note');
    Route::delete('/enquiries/{enquiry}', [AdminEnquiryController::class, 'destroy'])->name('enquiries.destroy');

    // Projects
    Route::resource('projects', ProjectController::class);

    // Hero Sliders (Website Management)
    Route::resource('hero-sliders', HeroSliderController::class);
    Route::post('/hero-sliders/{hero_slider}/toggle-status', [HeroSliderController::class, 'toggleStatus'])->name('hero-sliders.toggle-status');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});
