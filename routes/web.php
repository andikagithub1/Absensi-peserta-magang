<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembinaController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest');
Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'store'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware(['auth', 'prevent.back'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pembina Routes (Admin only)
    Route::middleware('admin')->group(function () {
        Route::get('/pembina', [PembinaController::class, 'index'])->name('pembina.index');
        Route::get('/pembina/create', [PembinaController::class, 'create'])->name('pembina.create');
        Route::post('/pembina', [PembinaController::class, 'store'])->name('pembina.store');
        Route::get('/pembina/{id}', [PembinaController::class, 'show'])->name('pembina.show');
        Route::get('/pembina/{id}/edit', [PembinaController::class, 'edit'])->name('pembina.edit');
        Route::put('/pembina/{id}', [PembinaController::class, 'update'])->name('pembina.update');
        Route::delete('/pembina/{id}', [PembinaController::class, 'destroy'])->name('pembina.destroy');

        // Peserta Routes (Admin only)
        Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta.index');
        Route::get('/peserta/create', [PesertaController::class, 'create'])->name('peserta.create');
        Route::post('/peserta', [PesertaController::class, 'store'])->name('peserta.store');
        Route::get('/peserta/{id}', [PesertaController::class, 'show'])->name('peserta.show');
        Route::get('/peserta/{id}/edit', [PesertaController::class, 'edit'])->name('peserta.edit');
        Route::put('/peserta/{id}', [PesertaController::class, 'update'])->name('peserta.update');
        Route::delete('/peserta/{id}', [PesertaController::class, 'destroy'])->name('peserta.destroy');
    });

    // Attendance Routes
    Route::resource('attendance', AttendanceController::class);
});

