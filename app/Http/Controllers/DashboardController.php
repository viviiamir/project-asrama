<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // 🌐 Dashboard utama (ambil data dari API PHP native)
    public function index()
    {
        $baseUrl = "http://localhost/asrama_iot/api";

        // Ambil data dari API eksternal (PHP Native)
        $notifications = Http::get("$baseUrl/notifications.php")->json();
        $siren         = Http::get("$baseUrl/siren.php")->json();
        $camera        = Http::get("$baseUrl/camera.php")->json();
        $distribution  = Http::get("$baseUrl/distribution.php")->json();

        // Ambil data terakhir
        $latestNotification = $notifications ? end($notifications) : null;
        $latestCamera       = $camera ? end($camera) : null;
        $latestDistribution = $distribution ? end($distribution) : null;

        return view('dashboard.index', compact(
            'notifications',
            'siren',
            'camera',
            'distribution',
            'latestNotification',
            'latestCamera',
            'latestDistribution'
        ));
    }

    // 📜 Halaman lain
    public function riwayat() { return view('dashboard.riwayat'); }
    public function kontak() { return view('dashboard.kontak'); }
    public function kamera() { return view('dashboard.kamera'); }
    public function distribusi() { return view('dashboard.distribusi'); }

    // 🔁 SSE (Server-Sent Events)
    public function sse()
    {
        // Header untuk SSE
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');

        while (true) {
            $latest = DB::table('riwayat')->orderBy('id', 'desc')->first();

            if ($latest) {
                echo "event: update\n";
                echo "data: " . json_encode($latest) . "\n\n";
                ob_flush();
                flush();
            }

            sleep(2); // kirim update setiap 2 detik
        }
    }
    public function testSSE()
{
    // Simulasi kirim data dummy ke tabel riwayat untuk uji real-time
    DB::table('riwayat')->insert([
        'device_id'     => 'F1-TestNode',
        'floor'         => 1,
        'event_type'    => 'SOS',
        'value'         => 'Button Pressed (Test)',
        'image_url'     => 'https://i.ibb.co/Nn9LxqV/fire.jpg',
        'notif_channel' => 'WEB, Telegram',
        'sirine_status' => 'ON',
        'timestamp'     => now()
    ]);

    return response()->json([
        'status'  => 'success',
        'message' => '✅ Data simulasi SSE berhasil dikirim!'
    ]);
}

}
