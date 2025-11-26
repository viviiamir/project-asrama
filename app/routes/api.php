<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RiwayatController;

// Default route bawaan Laravel (boleh biarkan)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 🚨 Tambahkan route POST RIWAYAT di sini
Route::post('/riwayat', [RiwayatController::class, 'store'])->name('api.riwayat.store');

// (Opsional) Tambahkan GET buat tes aja
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('api.riwayat.index');
