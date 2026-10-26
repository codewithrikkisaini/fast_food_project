<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Fast Food & Foodie Admin
|--------------------------------------------------------------------------
*/

// ==========================================
// FRONTEND ROUTES
// ==========================================
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/menu', [FrontendController::class, 'menu'])->name('menu');
Route::get('/chefs', [FrontendController::class, 'chefs'])->name('chefs');
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('gallery');
Route::get('/reviews', [FrontendController::class, 'reviews'])->name('reviews');
Route::post('/reviews', [FrontendController::class, 'storeReview'])->name('reviews.store');

// Reservation Routes
Route::get('/reservation', [FrontendController::class, 'reservation'])->name('reservation');
Route::post('/reservation', [FrontendController::class, 'storeReservation'])->name('reservation.store');

// Blog Routes
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog/{id}', [FrontendController::class, 'blogDetail'])->name('blog.detail');

// Contact Routes
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact', [FrontendController::class, 'storeContact'])->name('contact.store');

// Cart & Order Routes
Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');


// ==========================================
// FOODIE ADMIN - RESTAURANT MANAGEMENT SYSTEM
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    // Landing (routes to Home as primary active view)
    Route::get('/', function () {
        return redirect()->route('admin.home');
    })->name('index');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Home Section Management
    Route::get('/home', [AdminController::class, 'home'])->name('home');
    Route::post('/home', [AdminController::class, 'updateHome'])->name('home.update');

    // About Section Management
    Route::get('/about', [AdminController::class, 'about'])->name('about');
    Route::post('/about', [AdminController::class, 'updateAbout'])->name('about.update');

    // Menu Management
    Route::get('/menu', [AdminController::class, 'menu'])->name('menu');
    Route::post('/menu/store', [AdminController::class, 'storeMenuItem'])->name('menu.store');
    Route::post('/menu/delete/{id}', [AdminController::class, 'deleteMenuItem'])->name('menu.delete');

    // Chefs Management
    Route::get('/chefs', [AdminController::class, 'chefs'])->name('chefs');
    Route::get('/chef', [AdminController::class, 'chefs'])->name('chef');
    Route::post('/chefs/store', [AdminController::class, 'storeChef'])->name('chefs.store');
    Route::post('/chefs/delete/{id}', [AdminController::class, 'deleteChef'])->name('chefs.delete');

    // Gallery Management
    Route::get('/gallery', [AdminController::class, 'gallery'])->name('gallery');
    Route::post('/gallery/store', [AdminController::class, 'storeGalleryItem'])->name('gallery.store');
    Route::post('/gallery/delete/{id}', [AdminController::class, 'deleteGalleryItem'])->name('gallery.delete');

    // Reservations Management
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations');
    Route::post('/reservations/status/{id}', [AdminController::class, 'updateReservationStatus'])->name('reservations.status');
    Route::post('/reservations/delete/{id}', [AdminController::class, 'deleteReservation'])->name('reservations.delete');

    // Reviews Management
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
    Route::post('/reviews/settings', [AdminController::class, 'updateReviewSettings'])->name('reviews.settings.update');
    Route::post('/reviews/store', [AdminController::class, 'storeReview'])->name('reviews.store');
    Route::post('/reviews/update/{id}', [AdminController::class, 'updateReviewItem'])->name('reviews.update');
    Route::post('/reviews/status/{id}', [AdminController::class, 'updateReviewStatus'])->name('reviews.status');
    Route::post('/reviews/delete/{id}', [AdminController::class, 'deleteReview'])->name('reviews.delete');
    Route::post('/reviews/delete-all', [AdminController::class, 'deleteAllReviews'])->name('reviews.delete.all');

    // Blog Articles Management
    Route::get('/blog', [AdminController::class, 'blog'])->name('blog');
    Route::post('/blog/store', [AdminController::class, 'storeBlogPost'])->name('blog.store');
    Route::post('/blog/update/{id}', [AdminController::class, 'updateBlogPost'])->name('blog.update');
    Route::post('/blog/delete/{id}', [AdminController::class, 'deleteBlogPost'])->name('blog.delete');

    // Contact Inquiries Management
    Route::get('/contact', [AdminController::class, 'contact'])->name('contact');
    Route::post('/contact/read/{id}', [AdminController::class, 'markContactRead'])->name('contact.read');
    Route::post('/contact/delete/{id}', [AdminController::class, 'deleteContact'])->name('contact.delete');

    // Restaurant Settings (Contact Info, Hours, Social Links)
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});
