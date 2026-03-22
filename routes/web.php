<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PerfumeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Admin\CatalogSettingsController;
use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Public\ParfumController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/parfum/{name}', [ParfumController::class, 'index'])->name('parfum');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
        Route::get('/usuarios/cadastrar', [UserController::class, 'create'])->name('users.create');
        Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
        Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::patch('/usuarios/{user}/status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

        Route::get('/perfumes', [PerfumeController::class, 'index'])->name('perfumes.index');
        Route::get('/perfumes/cadastrar', [PerfumeController::class, 'create'])->name('perfumes.create');
        Route::post('/perfumes', [PerfumeController::class, 'store'])->name('perfumes.store');
        Route::get('/perfumes/{perfume}/editar', [PerfumeController::class, 'edit'])->name('perfumes.edit');
        Route::put('/perfumes/{perfume}', [PerfumeController::class, 'update'])->name('perfumes.update');
        Route::delete('/perfumes/{perfume}', [PerfumeController::class, 'destroy'])->name('perfumes.destroy');
        Route::patch('/perfumes/{perfume}/status', [PerfumeController::class, 'toggleStatus'])->name('perfumes.toggle-status');

        Route::get('/configuracoes-catalogo', [CatalogSettingsController::class, 'index'])->name('catalog-settings.index');
        Route::post('/configuracoes-catalogo/familias', [CatalogSettingsController::class, 'storeFamily'])->name('catalog-settings.families.store');
        Route::post('/configuracoes-catalogo/concentracoes', [CatalogSettingsController::class, 'storeConcentration'])->name('catalog-settings.concentrations.store');
        Route::post('/configuracoes-catalogo/ocasioes', [CatalogSettingsController::class, 'storeOccasion'])->name('catalog-settings.occasions.store');
        Route::post('/configuracoes-catalogo/intensidades', [CatalogSettingsController::class, 'storeIntensity'])->name('catalog-settings.intensities.store');
        Route::post('/configuracoes-catalogo/tags', [CatalogSettingsController::class, 'storeTag'])->name('catalog-settings.tags.store');
        Route::post('/configuracoes-catalogo/colecoes', [CatalogSettingsController::class, 'storeCollection'])->name('catalog-settings.collections.store');
        Route::get('/configuracoes-catalogo/{type}/{id}/editar', [CatalogSettingsController::class, 'edit'])->name('catalog-settings.edit');
        Route::put('/configuracoes-catalogo/{type}/{id}', [CatalogSettingsController::class, 'update'])->name('catalog-settings.update');
        Route::delete('/configuracoes-catalogo/{type}/{id}', [CatalogSettingsController::class, 'destroy'])->name('catalog-settings.destroy');
    });
