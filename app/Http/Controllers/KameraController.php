<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


use App\Models\Riwayat;

class KameraController extends Controller
{   
    public function uploadImage(Request $request)
{
    $request->validate([
        'device_id' => 'required',
        'image_base64' => 'required'
    ]);

    // Proses Base64 → JPG
    $image = $request->image_base64;
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);

    $imageName = 'esp32cam_' . time() . '.jpg';
    $filePath = public_path('uploads/' . $imageName);
    
    file_put_contents($filePath, base64_decode($image));

    // Simpan ke DB
    Riwayat::create([
        'device_id' => $request->device_id,
        'floor' => $request->floor ?? 0,
        'event_type' => $request->event_type ?? 'IMAGE',
        'value' => 'snapshot',
        'timestamp' => now(),
        'image_url' => asset('uploads/' . $imageName)
    ]);

    return response()->json([
        'status' => 'success',
        'url' => asset('uploads/' . $imageName)
    ]);
}

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
