<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembinaController;
use App\Http\Controllers\PesertaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest');
Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'store'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes - All authenticated users
Route::middleware(['auth', 'prevent.back'])->group(function () {
    // Dashboard - Accessible to all authenticated users (redirects based on role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Attendance Routes - Accessible to all authenticated users
    Route::resource('attendance', AttendanceController::class);
});

// Admin-only Routes - Pembina and Peserta management
// Use custom middleware that doesn't require auth first (so 403 instead of 401)
Route::middleware(['prevent.back', 'check.admin.access'])->group(function () {
    // Admin Dashboard
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.index');

    // Pembina Management
    Route::get('/pembina', [PembinaController::class, 'index'])->name('pembina.index');
    Route::get('/pembina/create', [PembinaController::class, 'create'])->name('pembina.create');
    Route::post('/pembina', [PembinaController::class, 'store'])->name('pembina.store');
    Route::get('/pembina/{id}', [PembinaController::class, 'show'])->name('pembina.show');
    Route::get('/pembina/{id}/edit', [PembinaController::class, 'edit'])->name('pembina.edit');
    Route::put('/pembina/{id}', [PembinaController::class, 'update'])->name('pembina.update');
    Route::get('/pembina/{id}/edit-password', [PembinaController::class, 'editPassword'])->name('pembina.edit-password');
    Route::put('/pembina/{id}/update-password', [PembinaController::class, 'updatePassword'])->name('pembina.update-password');
    Route::delete('/pembina/{id}', [PembinaController::class, 'destroy'])->name('pembina.destroy');

    // Peserta Management
    Route::get('/peserta', [PesertaController::class, 'index'])->name('peserta.index');
    Route::get('/peserta/create', [PesertaController::class, 'create'])->name('peserta.create');
    Route::post('/peserta', [PesertaController::class, 'store'])->name('peserta.store');
    Route::get('/peserta/{id}', [PesertaController::class, 'show'])->name('peserta.show');
    Route::get('/peserta/{id}/edit', [PesertaController::class, 'edit'])->name('peserta.edit');
    Route::put('/peserta/{id}', [PesertaController::class, 'update'])->name('peserta.update');
    Route::get('/peserta/{id}/edit-password', [PesertaController::class, 'editPassword'])->name('peserta.edit-password');
    Route::put('/peserta/{id}/update-password', [PesertaController::class, 'updatePassword'])->name('peserta.update-password');
    Route::delete('/peserta/{id}', [PesertaController::class, 'destroy'])->name('peserta.destroy');
});
