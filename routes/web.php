<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\AdocaoController;
use App\Http\Controllers\AcessoController;
use App\Http\Middleware\TrackPageViews;

// Páginas públicas com middleware de rastreamento
Route::middleware([TrackPageViews::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/como-ajudar', [PageController::class, 'help'])->name('como.ajudar');
    Route::get('/institucional', [PageController::class, 'about'])->name('institucional');
    Route::get('/depoimentos', [TestimonialController::class, 'index'])->name('depoimentos');
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::get('/noticias', [NewsController::class, 'index'])->name('noticias');
    Route::get('/noticias', [NewsController::class, 'index'])->name('news.index');
    Route::get('/parceiros', [PartnerController::class, 'index'])->name('parceiros');
    Route::get('/parceiros', [PartnerController::class, 'index'])->name('partners.index');
    Route::get('/adote', [AdocaoController::class, 'index'])->name('adote');
    Route::get('/noticias/{news}', [NewsController::class, 'show'])->name('news.show');
    Route::get('/redes-sociais', [PageController::class, 'social'])->name('social.index');
});

// Rotas protegidas para painel admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Notícias
    Route::get('/news', [NewsController::class, 'index'])->name('admin.news.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('admin.news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('admin.news.store');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('admin.news.destroy');

    // Depoimentos
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('admin.testimonials.index');
    Route::get('/testimonials/create', [TestimonialController::class, 'create'])->name('admin.testimonials.create');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('admin.testimonials.store');
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('admin.testimonials.destroy');

    // Parceiros
    Route::get('/parceiros/create', [PartnerController::class, 'create'])->name('admin.parceiros.create');
    Route::post('/parceiros', [PartnerController::class, 'store'])->name('admin.parceiros.store');
    Route::delete('/parceiros/{partner}', [PartnerController::class, 'destroy'])->name('admin.parceiros.destroy');

    // Pets
    Route::get('/pets', [PetController::class, 'index'])->name('admin.pets.index');
    Route::get('/pets/create', [PetController::class, 'create'])->name('admin.pets.create');
    Route::post('/pets', [PetController::class, 'store'])->name('admin.pets.store');
    Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('admin.pets.destroy');
    Route::get('/pets/{pet}/toggle', [PetController::class, 'toggleStatus'])->name('admin.pets.toggleStatus');

    // Acessos
    Route::get('/acessos', [AcessoController::class, 'index'])->name('admin.acessos.index');
    Route::get('/acessos/export', [AcessoController::class, 'export'])->name('admin.acessos.export');
    Route::get('/acessos/dashboard', [AcessoController::class, 'dashboard'])->name('admin.acessos.dashboard');
});

// Inclusões finais
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
