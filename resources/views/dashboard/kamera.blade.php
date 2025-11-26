@extends('layouts.app')
@section('title', 'Kamera ESP32-CAM')

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

<div class="container container-kamera">
    <h2 class="fw-bold mb-3">📷 Kamera ESP32-CAM</h2>
    <p class="text-muted">
        Menampilkan hasil tangkapan kamera terbaru dari node ESP32-CAM serta data sensor terkait.
    </p>

    {{-- 🖼️ Gambar Terbaru --}}
    @if ($latest)
        <div class="text-center mb-4">
            <img id="esp32-image"
                 src="{{ $latest->image_url }}"
                 class="img-fluid border rounded-3 shadow-sm"
                 alt="ESP32-CAM"
                 style="max-height:400px; object-fit:contain;">
            <p class="mt-2 text-secondary small" id="updated-time">
                📸 Gambar terakhir diperbarui: <b>{{ $latest->timestamp }}</b>
            </p>
        </div>
    @else
        <p class="text-secondary mt-4">Belum ada foto kondisi terbaru.</p>
    @endif

    {{-- 🧾 Data Node Terbaru --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Device ID</th>
                    <th>Lantai</th>
                    <th>Event Type</th>
                    <th>Nilai</th>
                    <th>Image URL</th>
                    <th>Notif Channel</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge bg-primary">{{ $item->device_id }}</span></td>
                        <td>{{ $item->floor }}</td>
                        <td>
                            <span class="badge 
                                @if($item->event_type == 'SMOKE') bg-danger 
                                @elseif($item->event_type == 'SOS') bg-warning text-dark 
                                @else bg-info text-dark 
                                @endif">
                                {{ $item->event_type }}
                            </span>
                        </td>
                        <td>{{ $item->value }}</td>
                        <td>
                            @if($item->image_url)
                                <a href="{{ $item->image_url }}" target="_blank">Lihat</a>
                            @else
                                <em>-</em>
                            @endif
                        </td>
                        <td>{{ $item->notif_channel }}</td>
                        <td>{{ $item->timestamp }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-muted">Belum ada data riwayat kamera.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- 🔁 Auto Refresh Gambar --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    setInterval(() => {
        fetch("{{ route('api.kamera.latest') }}")
            .then(res => res.json())
            .then(data => {
                if (data.image_url) {
                    document.getElementById('esp32-image').src = data.image_url + '?t=' + new Date().getTime();
                    document.getElementById('updated-time').innerHTML =
                        "📸 Gambar terakhir diperbarui: <b>" + data.timestamp + "</b>";
                }
            })
            .catch(err => console.error('Gagal memuat foto:', err));
    }, 10000); // refresh tiap 10 detik
});
</script>
@endsection
