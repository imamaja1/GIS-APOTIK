<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApotekController;
use App\Http\Controllers\Admin\AdminApotekController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminKecamatanController;
use App\Http\Controllers\Admin\AdminMapController;
use App\Http\Controllers\Admin\AdminMasterApotekController;
use App\Http\Controllers\Admin\AdminSearchController;
use Illuminate\Support\Facades\Route;

// Redirect root ke login
Route::get('/', fn () => redirect()->route('login'));

// ===== Auth Routes (hanya untuk tamu) =====
Route::middleware(['guest:web,admin'])->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== Panel Admin (guard admin) =====
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/data-apotek', [AdminApotekController::class, 'index'])->name('data-apotek');
    Route::get('/data-apotek/{apotek}/detail', [AdminApotekController::class, 'detail'])->name('data-apotek.detail');
    Route::get('/search-apotek', [AdminSearchController::class, 'index'])->name('search-apotek');
    Route::get('/peta-apotek', [AdminMapController::class, 'index'])->name('peta.index');

    // Kecamatan (CRUD)
    Route::get('/kecamatan', [AdminKecamatanController::class, 'index'])->name('kecamatan.index');
    Route::post('/kecamatan', [AdminKecamatanController::class, 'store'])->name('kecamatan.store');
    Route::get('/kecamatan/{kecamatan}/edit', [AdminKecamatanController::class, 'edit'])->name('kecamatan.edit');
    Route::put('/kecamatan/{kecamatan}', [AdminKecamatanController::class, 'update'])->name('kecamatan.update');
    Route::delete('/kecamatan/{kecamatan}', [AdminKecamatanController::class, 'destroy'])->name('kecamatan.destroy');

    // Apotek (CRUD)
    Route::get('/apotek', [AdminMasterApotekController::class, 'index'])->name('apotek.index');
    Route::get('/apotek/create', [AdminMasterApotekController::class, 'create'])->name('apotek.create');
    Route::post('/apotek', [AdminMasterApotekController::class, 'store'])->name('apotek.store');
    Route::get('/apotek/{apotek}/edit', [AdminMasterApotekController::class, 'edit'])->name('apotek.edit');
    Route::put('/apotek/{apotek}', [AdminMasterApotekController::class, 'update'])->name('apotek.update');
    Route::delete('/apotek/{apotek}', [AdminMasterApotekController::class, 'destroy'])->name('apotek.destroy');

    // AJAX endpoints (admin)
    Route::get('/apotek/cari',         [ApotekController::class, 'searchJson'])->name('apotek.search-json');
    Route::get('/apotek/{id}/detail',  [ApotekController::class, 'detail'])->name('apotek.detail');

});

// ===== Panel User (harus login) =====
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard',   [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/data-apotek', [ApotekController::class, 'index'])->name('data-apotek');
    Route::get('/search-apotek', [ApotekController::class, 'search'])->name('search-apotek');

    // AJAX endpoints
    Route::get('/apotek/cari',         [ApotekController::class, 'searchJson'])->name('apotek.search-json');
    Route::get('/apotek/{id}/detail',  [ApotekController::class, 'detail'])->name('apotek.detail');
});
