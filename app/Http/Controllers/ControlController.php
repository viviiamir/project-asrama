<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ControlController extends Controller
{
    /**
     * 🟢 Mengambil status sirine untuk ESP32
     * Endpoint: GET /api/control
     */
    public function get()
    {
        // Ambil nilai terakhir dari cache, default = AUTO
        $status = Cache::get('sirine_status', 'AUTO');
        return response($status, 200)
               ->header('Content-Type', 'text/plain');
    }

    /**
     * 🔴 Menyimpan status sirine dari Dashboard
     * Endpoint: POST /api/control
     */
    public function set(Request $request)
    {
        $status = strtoupper($request->input('status', 'AUTO'));

        // Validasi agar hanya menerima 3 nilai sah
        if (!in_array($status, ['ON', 'OFF', 'AUTO'])) {
            return response()->json(['error' => 'Status tidak valid'], 400);
        }

        // Simpan di cache selama 1 jam (3600 detik)
        Cache::put('sirine_status', $status, 3600);

        return response()->json([
            'success' => true,
            'status' => $status,
            'message' => 'Status sirine berhasil diperbarui'
        ]);
    }
}
