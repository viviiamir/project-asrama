<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\KameraController;
use App\Http\Controllers\KontakController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard utama
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Halaman web
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
// Route::get('/kontak', [DashboardController::class, 'kontak'])->name('kontak');
Route::get('/distribusi', [DistribusiController::class, 'index'])->name('distribusi');
Route::get('/kamera', [KameraController::class, 'index'])->name('kamera.index');
Route::get('/kamera/latest', [KameraController::class, 'latestImage'])->name('kamera.latest');

// Kontak 
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');
Route::get('/kontak/create', [KontakController::class, 'create'])->name('kontak.create');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');
Route::get('/kontak/{id}/edit', [KontakController::class, 'edit'])->name('kontak.edit');
Route::put('/kontak/{id}', [KontakController::class, 'update'])->name('kontak.update');
Route::delete('/kontak/{id}', [KontakController::class, 'destroy'])->name('kontak.destroy');

// SSE (real-time)
Route::get('/dashboard/sse', [DashboardController::class, 'sse'])->name('dashboard.sse');

Route::post('/dashboard/sse/test', [DashboardController::class, 'testSSE'])->name('dashboard.sse.test');