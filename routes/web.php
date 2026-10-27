<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesUserController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - RuteSales Application
|--------------------------------------------------------------------------
| Pola Arsitektur MVC (Model-View-Controller) dengan definisi Routes yang jelas.
*/

// Halaman utama mengarahkan ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Autentikasi Pengguna & Fitur Demo Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/quick-login/{id}', [AuthController::class, 'quickLogin'])->name('quick.login');

// Group Route yang Dapat Diakses Pengguna
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Modul 1: Pengelolaan Data Toko/Warung (CRUD)
Route::resource('stores', StoreController::class);

// Modul 2: Pengelolaan Data Sales/Pengguna (CRUD)
Route::resource('sales', SalesUserController::class);

// Modul 3: Pengelolaan Data Rute Kunjungan (CRUD & Transaksi)
Route::prefix('rute')->name('rute.')->group(function () {
    Route::get('/', [VisitController::class, 'index'])->name('index');
    Route::get('/create', [VisitController::class, 'create'])->name('create');
    Route::post('/', [VisitController::class, 'store'])->name('store');

    // URI Dinamis Spesifik Sesuai Persyaratan Proyek: /rute/detail/{id}
    Route::get('/detail/{id}', [VisitController::class, 'detail'])->name('detail');

    // Formulir Check-In Kunjungan (Server-side validation & CSRF Protected)
    Route::post('/checkin/{id}', [VisitController::class, 'checkin'])->name('checkin');

    Route::get('/{id}/edit', [VisitController::class, 'edit'])->name('edit');
    Route::put('/{id}', [VisitController::class, 'update'])->name('update');
    Route::delete('/{id}', [VisitController::class, 'destroy'])->name('destroy');
});

// Alias fleksibel: /visits/{id} mengarah ke /rute/detail/{id}
Route::get('/visits/{id}', function ($id) {
    return redirect()->route('rute.detail', $id);
});
