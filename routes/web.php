<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Fast Food & Foodie Admin
|--------------------------------------------------------------------------
*/

// ==========================================
// FRONTEND ROUTES
// ==========================================
Route::get('/', [Frontend\HomeController::class, 'index'])->name('home');
Route::get('/about', [Frontend\AboutController::class, 'index'])->name('about');
Route::get('/menu', [Frontend\MenuController::class, 'index'])->name('menu');
Route::get('/chefs', [Frontend\ChefController::class, 'index'])->name('chefs');
Route::get('/gallery', [Frontend\GalleryController::class, 'index'])->name('gallery');
Route::get('/reviews', [Frontend\ReviewController::class, 'index'])->name('reviews');
Route::post('/reviews', [Frontend\ReviewController::class, 'store'])->name('reviews.store');

// Reservation Routes
Route::get('/reservation', [Frontend\ReservationController::class, 'index'])->name('reservation');
Route::post('/reservation', [Frontend\ReservationController::class, 'store'])->name('reservation.store');

// Blog Routes
Route::get('/blog', [Frontend\BlogController::class, 'index'])->name('blog');
Route::get('/blog/{id}', [Frontend\BlogController::class, 'show'])->name('blog.detail');

// Contact Routes
Route::get('/contact', [Frontend\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [Frontend\ContactController::class, 'store'])->name('contact.store');

// Cart & Order Routes
Route::get('/cart', [Frontend\CartController::class, 'index'])->name('cart');


// ==========================================
// FOODIE ADMIN - RESTAURANT MANAGEMENT SYSTEM
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Landing (routes to Home as primary active view)
    Route::get('/', function () {
        return redirect()->route('admin.home');
    })->name('index');
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Home Section Management
    Route::get('/home', [Admin\HomeController::class, 'index'])->name('home');
    Route::post('/home', [Admin\HomeController::class, 'update'])->name('home.update');

    // About Section Management
    Route::get('/about', [Admin\AboutController::class, 'index'])->name('about');
    Route::post('/about', [Admin\AboutController::class, 'update'])->name('about.update');

    // Menu Management
    Route::get('/menu', [Admin\MenuController::class, 'index'])->name('menu');
    Route::post('/menu/store', [Admin\MenuController::class, 'store'])->name('menu.store');
    Route::post('/menu/delete/{id}', [Admin\MenuController::class, 'destroy'])->name('menu.delete');

    // Chefs Management
    Route::get('/chefs', [Admin\ChefController::class, 'index'])->name('chefs');
    Route::get('/chef', [Admin\ChefController::class, 'index'])->name('chef');
    Route::post('/chefs/store', [Admin\ChefController::class, 'store'])->name('chefs.store');
    Route::post('/chefs/delete/{id}', [Admin\ChefController::class, 'destroy'])->name('chefs.delete');

    // Gallery Management
    Route::get('/gallery', [Admin\GalleryController::class, 'index'])->name('gallery');
    Route::post('/gallery/store', [Admin\GalleryController::class, 'store'])->name('gallery.store');
    Route::post('/gallery/delete/{id}', [Admin\GalleryController::class, 'destroy'])->name('gallery.delete');

    // Reservations Management
    Route::get('/reservations', [Admin\ReservationController::class, 'index'])->name('reservations');
    Route::post('/reservations/status/{id}', [Admin\ReservationController::class, 'updateStatus'])->name('reservations.status');
    Route::post('/reservations/delete/{id}', [Admin\ReservationController::class, 'destroy'])->name('reservations.delete');

    // Reviews Management
    Route::get('/reviews', [Admin\ReviewController::class, 'index'])->name('reviews');
    Route::post('/reviews/settings', [Admin\ReviewController::class, 'updateSettings'])->name('reviews.settings.update');
    Route::post('/reviews/store', [Admin\ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/reviews/update/{id}', [Admin\ReviewController::class, 'update'])->name('reviews.update');
    Route::post('/reviews/status/{id}', [Admin\ReviewController::class, 'updateStatus'])->name('reviews.status');
    Route::post('/reviews/delete/{id}', [Admin\ReviewController::class, 'destroy'])->name('reviews.delete');
    Route::post('/reviews/delete-all', [Admin\ReviewController::class, 'destroyAll'])->name('reviews.delete.all');

    // Blog Articles Management
    Route::get('/blog', [Admin\BlogController::class, 'index'])->name('blog');
    Route::post('/blog/store', [Admin\BlogController::class, 'store'])->name('blog.store');
    Route::post('/blog/update/{id}', [Admin\BlogController::class, 'update'])->name('blog.update');
    Route::post('/blog/delete/{id}', [Admin\BlogController::class, 'destroy'])->name('blog.delete');

    // Contact Inquiries Management
    Route::get('/contact', [Admin\ContactController::class, 'index'])->name('contact');
    Route::post('/contact/read/{id}', [Admin\ContactController::class, 'markRead'])->name('contact.read');
    Route::post('/contact/delete/{id}', [Admin\ContactController::class, 'destroy'])->name('contact.delete');

    // Restaurant Settings (Contact Info, Hours, Social Links)
    Route::get('/settings', [Admin\SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');
});
