<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;

class KameraController extends Controller
{
    // 🌇 Halaman utama kamera
    public function index()
    {
        // Ambil 10 data terbaru dari tabel riwayat untuk ditampilkan
        $riwayat = Riwayat::orderBy('timestamp', 'desc')->take(10)->get();

        // Ambil foto terbaru (yang punya image_url tidak null)
        $latest = Riwayat::whereNotNull('image_url')
                    ->orderBy('timestamp', 'desc')
                    ->first();

        // Kirim keduanya ke view
        return view('dashboard.kamera', compact('riwayat', 'latest'));
    }

    // 📸 API untuk mengirim foto terbaru (dipakai oleh dashboard & auto-refresh)
    public function latestImage()
    {
        // Ambil data gambar terakhir dari tabel riwayat
        $latest = Riwayat::whereNotNull('image_url')
                    ->orderBy('timestamp', 'desc')
                    ->first();

        if ($latest) {
            return response()->json([
                'image_url' => $latest->image_url,
                'timestamp' => $latest->timestamp,
                'device_id' => $latest->device_id,
                'event_type' => $latest->event_type
            ]);
        }

        // Jika belum ada gambar di tabel riwayat
        return response()->json([
            'message' => 'Belum ada foto kondisi terbaru.',
            'image_url' => asset('asrama_iot/uploads/latest.jpg'),
            'timestamp' => now()->format('Y-m-d H:i:s')
        ]);
    }
}
