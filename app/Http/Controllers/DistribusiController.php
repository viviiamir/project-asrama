<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat;

class DistribusiController extends Controller
{
    public function index()
    {
        // Ambil semua data riwayat dengan channel Telegram (case-insensitive)
        $logs = Riwayat::whereRaw("LOWER(notif_channel) LIKE ?", ['%telegram%'])
            ->orderBy('timestamp', 'desc')
            ->take(20)
            ->get();

        // Pastikan selalu kirim variabel meski kosong
        return view('dashboard.distribusi', ['logs' => $logs]);
    }
}
