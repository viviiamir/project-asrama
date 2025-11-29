@extends('layouts.app')
@section('title', 'Kamera ESP32-CAM')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <h2 class="fw-bold mb-3">📷 Kamera ESP32-CAM</h2>
            <p class="text-muted">
                Halaman ini menampilkan hasil tangkapan kamera dan data sensor dari Node (ESP32).
            </p>

            {{-- Gambar Utama --}}
            <div class="text-center mb-4">
                <img id="esp32-image"
                     src="{{ asset('asrama_iot/uploads/latest.jpg') }}"
                     class="img-fluid border rounded-3 shadow-sm"
                     alt="ESP32-CAM"
                     style="max-height:400px; object-fit:contain;">
                <p class="mt-2 text-secondary small" id="updated-time">
                    📸 Gambar terakhir diperbarui: <b>{{ now()->format('Y-m-d H:i:s') }}</b>
                </p>
            </div>

            {{-- Data Node --}}
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Device ID</th>
                            <th>Lantai</th>
                            <th>Jenis Kejadian</th>
                            <th>Nilai Sensor</th>
                            <th>Image URL</th>
                            <th>Notif Channel</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody id="riwayat-table">
                        @foreach($riwayat as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="badge bg-primary">{{ $item->device_id }}</span></td>
                            <td>{{ $item->floor }}</td>
                            <td>
                                <span class="badge 
                                    @if($item->event_type == 'SMOKE') bg-danger 
                                    @elseif($item->event_type == 'FIRE') bg-warning text-dark 
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
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Penjelasan --}}
            <div class="alert alert-light border mt-4">
                <h5 class="fw-bold">🧭 Data yang ditransmisikan dari Node ke Server meliputi:</h5>
                <ul>
                    <li><b>Device ID:</b> Identitas node (misalnya Lantai 2 – Zona Tengah).</li>
                    <li><b>Floor:</b> Nomor lantai lokasi node.</li>
                    <li><b>Event Type:</b> Jenis kejadian (<code>SMOKE</code>, <code>FIRE</code>, <code>IMAGE</code>).</li>
                    <li><b>Value:</b> Nilai sensor (MQ-2, tombol SOS, suhu/kelembaban DHT11/DHT22).</li>
                    <li><b>Image_URL:</b> Link gambar terbaru dari ESP32-CAM.</li>
                    <li><b>Notif_Channel:</b> Jalur notifikasi (WEB, SMS, WA, Telegram).</li>
                    <li><b>Timestamp:</b> Waktu kejadian dikirim ke server.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT AUTO REFRESH --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    setInterval(() => {
        // Ganti gambar tanpa reload seluruh halaman
        const img = document.getElementById('esp32-image');
        img.src = "{{ asset('asrama_iot/uploads/latest.jpg') }}" + "?t=" + new Date().getTime();

        // Update timestamp
        fetch("{{ route('kamera.latest') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('updated-time').innerHTML =
                    "📸 Gambar terakhir diperbarui: <b>" + data.timestamp + "</b>";
            })
            .catch(err => console.log(err));
    }, 10000); // refresh tiap 10 detik
});
</script>
@endsection
