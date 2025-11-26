@extends('layouts.app')
@section('title', 'Distribusi Notifikasi')

@section('content')
@php use Illuminate\Support\Str; @endphp
<style>
body {
    background: url("{{ asset('foto-uts.jpg') }}") no-repeat center center fixed;
    background-size: cover;
}
.container-kamera {
    background: rgba(255, 255, 255, 0.7);
    border-radius: 20px;
    padding: 30px;
    margin-top: 40px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    text-align: center;
}
img {
    border-radius: 15px;
    max-width: 90%;
    box-shadow: 0 0 15px rgba(0,0,0,0.3);
}
</style>
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">
            <h2 class="fw-bold mb-3">📤 Status Distribusi Notifikasi</h2>
            <p class="text-muted">Log pengiriman notifikasi ke Telegram.</p>

            {{-- 🔹 Tabel Distribusi --}}
            <div class="table-responsive mt-4">
                <table class="table table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Device</th>
                            <th>Lantai</th>
                            <th>Event</th>
                            <th>Channel</th>
                            <th>Status</th>
                            <th>Pesan</th>
                            <th>Foto</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="badge bg-primary">{{ $log->device_id }}</span></td>
                            <td>{{ $log->floor }}</td>
                            <td>
                                @if($log->event_type == 'SMOKE')
                                    <span class="badge bg-danger">SMOKE</span>
                                @elseif($log->event_type == 'SOS')
                                    <span class="badge bg-warning text-dark">SOS</span>
                                @elseif($log->event_type == 'IMAGE')
                                    <span class="badge bg-info text-dark">IMAGE</span>
                                @else
                                    <span class="badge bg-secondary">UNKNOWN</span>
                                @endif
                            </td>
                            <td>{{ $log->notif_channel ?? '-' }}</td>
                            <td>
                                <span class="badge 
                                    {{ $log->status == 'SUCCESS' ? 'bg-success' : 
                                       ($log->status == 'FAILED' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ $log->status }}
                                </span>
                            </td>
                            <td class="text-start small">{{ Str::limit($log->message, 80) }}</td>
                            <td>
                                @if($log->image_url)
                                    <a href="{{ $log->image_url }}" target="_blank" 
                                       class="btn btn-outline-info btn-sm rounded-pill">📷</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $log->timestamp }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-muted">Belum ada log distribusi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 🔹 Bagian Bukti Notifikasi Telegram --}}
            <div class="mt-5 p-4 bg-light border rounded-3 shadow-sm">
                <h5 class="fw-bold mb-2">📲 Bukti Pengiriman Notifikasi Telegram</h5>
                <p class="text-muted small">
                    Jika status pengiriman <strong class="text-success">SUCCESS</strong>,
                    notifikasi telah berhasil terkirim ke <strong>Telegram Channel</strong> 
                    yang sudah terhubung dengan sistem IoT Asrama.
                </p>
                <ul class="mb-3">
                    <li>Pesan dikirim oleh <code>TelegramService.php</code> menggunakan bot API Telegram.</li>
                    <li>Format pesan mencakup <b>Device ID</b>, <b>Lantai</b>, <b>Event Type</b>, dan <b>Waktu Kejadian</b>.</li>
                    <li>Jika ada foto dari ESP32-CAM, sistem akan menambahkan <b>tautan gambar otomatis</b>.</li>
                </ul>
                <div class="alert alert-info small border-0">
                    💡 <b>Tips:</b> Untuk melihat bukti notifikasi secara langsung, 
                    buka aplikasi Telegram Anda dan cari pesan dengan format seperti:
                    <pre class="mt-2 bg-white p-3 rounded shadow-sm">
📢 IoT Asrama Alert!
Device: Lantai 2 - Zona Tengah
Event : SMOKE detected 🚨
Status: SUCCESS
Waktu : 2025-10-10 20:45:12
[Foto] http://localhost/asrama_iot/uploads/latest.jpg
                    </pre>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
