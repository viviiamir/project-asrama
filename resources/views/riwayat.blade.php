@extends('layouts.app')
@section('title', 'Riwayat Kejadian')

@section('content')
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
            <h2 class="fw-bold mb-3">📜 Riwayat Kejadian</h2>
            <p class="text-muted">Data dikirim dari Node (ESP32) ke server via API.</p>

            <div class="table-responsive mt-4">
                <table class="table table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Device ID</th>
                            <th>Lantai</th>
                            <th>Jenis Kejadian</th>
                            <th>Nilai Sensor</th>
                            <th>Foto</th>
                            <th>Notifikasi</th>
                            <th>Waktu</th>
                            <th>Sirine</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($riwayat as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="badge bg-primary">{{ $r->device_id }}</span></td>
                            <td>{{ $r->floor }}</td>
                            <td>
                                @if($r->event_type == 'SMOKE')
                                    <span class="badge bg-danger">SMOKE</span>
                                @elseif($r->event_type == 'SOS')
                                    <span class="badge bg-warning text-dark">SOS</span>
                                @else
                                    <span class="badge bg-success">NORMAL</span>
                                @endif
                            </td>
                            <td>{{ $r->value }}</td>
                            <td>
                                @if($r->image_url)
                                    <a href="{{ $r->image_url }}" target="_blank" class="btn btn-outline-info btn-sm rounded-pill">📷</a>
                                @else
                                    <span class="text-muted fst-italic">-</span>
                                @endif
                            </td>
                            <td><span class="badge bg-success">{{ $r->notif_channel }}</span></td>
                            <td>{{ $r->timestamp }}</td>
                            <td>
                                <span class="badge {{ $r->sirine_status == 'ON' ? 'bg-danger' : 'bg-secondary' }}">
                                    {{ $r->sirine_status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-muted">Belum ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
