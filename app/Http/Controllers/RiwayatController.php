<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat;
use App\Models\Distribusi;
use App\Services\TelegramService;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = Riwayat::orderBy('timestamp', 'desc')->get();
        return view('riwayat', compact('riwayat'));
    }

    public function apiIndex()
    {
        $riwayat = Riwayat::orderBy('timestamp', 'desc')->get();
        return response()->json($riwayat);
    }

    // 🚨 Menerima data dari ESP32 / Postman
    public function store(Request $request, ?TelegramService $tg = null)
    {
        $validated = $request->validate([
            'device_id' => 'required|string',
            'floor' => 'required|integer',
            'event_type' => 'required|string',
            'value' => 'nullable|string',
            'image_url' => 'nullable|string',
            'notif_channel' => 'nullable|string',
        ]);

        $sirineStatus = in_array(strtoupper($request->event_type), ['SMOKE', 'SOS'])
            ? 'ON' : 'OFF';

        $data = Riwayat::create([
            'device_id' => $request->device_id,
            'floor' => $request->floor,
            'event_type' => strtoupper($request->event_type),
            'value' => $request->value,
            'image_url' => $request->image_url,
            'notif_channel' => 'WEB, Telegram',
            'sirine_status' => $sirineStatus,
            'ack_status' => 'PENDING',
            'resolve_status' => 'OPEN',
            'timestamp' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan',
            'data' => $data,
        ]);
    }

    // ✅ Petugas menekan tombol ACK
    public function acknowledge($id)
    {
        $riwayat = Riwayat::findOrFail($id);
        $riwayat->update(['ack_status' => 'ACK']);
        return response()->json(['message' => 'Notifikasi dikonfirmasi (ACK)']);
    }

    // ✅ Petugas menekan tombol RESOLVE (menyelesaikan kasus)
    public function resolve($id)
    {
        $riwayat = Riwayat::findOrFail($id);
        $riwayat->update([
            'resolve_status' => 'RESOLVED',
            'sirine_status' => 'OFF'
        ]);
        return response()->json(['message' => 'Kasus diselesaikan dan sirine dimatikan']);
    }
}
