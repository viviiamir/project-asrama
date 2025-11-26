<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\KameraController;
use App\Http\Controllers\ControlController;

// Default route bawaan Laravel (boleh biarkan)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 🚨 Route API utama untuk Riwayat
Route::post('/riwayat', [RiwayatController::class, 'store'])->name('api.riwayat.store');
Route::get('/riwayat', [RiwayatController::class, 'apiIndex'])->name('api.riwayat.index'); // ✅ versi JSON untuk dashboard

Route::post('/riwayat/{id}/ack', [RiwayatController::class, 'acknowledge'])->name('api.riwayat.ack');
Route::post('/riwayat/{id}/resolve', [RiwayatController::class, 'resolve'])->name('api.riwayat.resolve');

// (Opsional) GET untuk melihat data riwayat via Postman / Browser
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('api.riwayat.index');

// =======================
// 🧠 SISTEM KONTROL SIRINE
// =======================
// Endpoint untuk membaca status sirine (digunakan ESP32)
Route::get('/control', function () {
    $path = base_path('control.txt');
    if (!File::exists($path)) {
        File::put($path, 'AUTO'); // default
    }
    return response(File::get($path), 200);
});

// Endpoint untuk mengubah status sirine (digunakan Dashboard / Postman)
Route::post('/control', function (Request $request) {
    $status = strtoupper($request->input('status', 'AUTO')); // ON / OFF / AUTO
    $path = base_path('control.txt');
    File::put($path, $status);
    return response()->json([
        'message' => 'Status sirine diperbarui',
        'status' => $status
    ]);
});

// =======================
// 📸 API FOTO TERBARU
// =======================
Route::get('/kamera/latest', [KameraController::class, 'latestImage'])->name('api.kamera.latest');


Route::get('/control', [ControlController::class, 'get']);
Route::post('/control', [ControlController::class, 'set']);