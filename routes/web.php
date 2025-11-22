<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Public\PublicController;

use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;

Route::controller(PublicController::class)->name('public.')->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/ajuda', 'help')->name('help');
    Route::get('/institucional', 'about')->name('about');
    Route::get('/parceiros', 'partners')->name('partners');
    Route::get('/depoimentos', 'testimonials')->name('testimonials');
    Route::post('/depoimentos', 'storeTestimonial')->name('testimonials.store');
    Route::get('/noticias', 'news')->name('news');
    Route::get('/noticias/{id}', 'showNews')->name('show-news');
});

Route::middleware(['auth.custom'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('dashboard')->controller(DashboardController::class)->name('dashboard.')->group(function () {
        Route::get('/', 'index')->name('index');
    });
    Route::prefix('partners')->controller(PartnerController::class)->name('partners.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    Route::prefix('testimonials')->controller(TestimonialController::class)->name('testimonials.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/pending', 'pending')->name('pending');
        Route::get('/moderate', 'moderate')->name('moderate');
        Route::post('/{id}/approve', 'approve')->name('approve');
        Route::post('/{id}/reject', 'reject')->name('reject');
    });
    Route::prefix('news')->controller(NewsController::class)->name('news.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::post('/{id}/delete-image', 'deleteImage')->name('deleteImage');
    });
    Route::prefix('users')->controller(UserController::class)->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
});

// Inclusões finais
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
