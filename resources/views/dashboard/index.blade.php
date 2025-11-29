@extends('layouts.app')
@section('title', 'Dashboard IoT Asrama')

@section('content')
<style>
body {
    background: url("{{ asset('foto-uts.jpg') }}") no-repeat center center fixed;
    background-size: cover;
}
.dashboard-container {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(6px);
    border-radius: 20px;
    padding: 30px;
    margin-top: 30px;
    box-shadow: 0 0 25px rgba(0,0,0,0.15);
}
.section-title { font-weight: bold; color: #222; margin-bottom: 15px; }
.btn-control {
    border-radius: 25px;
    font-weight: bold;
    padding: 15px 30px; /* area klik diperlebar */
    transition: 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 200px; /* biar area klik lebih luas */
    text-align: center;
    cursor: pointer;
}
.btn-control:hover { transform: scale(1.05); filter: brightness(1.05); }
.btn-control:active { transform: scale(0.97); filter: brightness(0.95); }

/* Tombol warna tetap */
.btn-success { background: #28a745; color: #fff; border: none; }
.btn-danger { background: #dc3545; color: #fff; border: none; }
.btn-secondary { background: #6c757d; color: #fff; border: none; }

.alert-box { border-radius: 12px; padding: 15px 20px; }
#alert-popup {
    position: fixed; top: 25px; right: 25px;
    background: rgba(220, 0, 0, 0.95); color: white;
    padding: 20px 25px; border-radius: 10px;
    z-index: 9999; display: none;
    box-shadow: 0 0 15px rgba(0,0,0,0.3);
    font-weight: bold;
}
.btn-test { background:#0d6efd; color:#fff; border:none; border-radius:8px; padding:6px 12px; cursor:pointer; }
.btn-test:hover { background:#0b5ed7; }
.loading { color: gray; font-style: italic; }

/* 🌐 Indikator SSE */
#sse-indicator {
    position: fixed;
    bottom: 12px;
    right: 15px;
    font-size: 13px;
    font-weight: bold;
    color: #fff;
    background: rgba(128,128,128,0.7);
    padding: 6px 12px;
    border-radius: 10px;
    z-index: 9999;
    transition: background 0.4s ease, transform 0.4s ease;
}
#sse-indicator.active { background: rgba(0,128,0,0.7); transform: scale(1.05); }
#sse-indicator.inactive { background: rgba(128,128,128,0.7); transform: scale(1); }
</style>

<div class="container dashboard-container">
    <h2 class="fw-bold mb-4 text-center">📊 Dashboard Monitoring & Kontrol IoT Asrama</h2>
    <p class="text-center text-muted mb-4">Pantau kondisi asrama secara real-time — notifikasi, foto, dan kontrol darurat.</p>

    {{-- 🔔 NOTIFIKASI AKTIF --}}
    <div id="notif-area" class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h4 class="section-title mb-0">📢 Notifikasi Aktif</h4>
            <button class="btn-test" id="toggle-sse" onclick="toggleSSE()">🧪 Tes SSE</button>
        </div>
        <div class="alert alert-info alert-box mt-2">Menunggu data notifikasi...</div>
    </div>

    {{-- 🚨 STATUS SIRINE --}}
    <div class="mb-4">
        <h4 class="section-title">🔔 Status Sirine</h4>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <span id="sirine-status" class="badge bg-secondary p-2 fs-6">Loading...</span>
            <div class="ms-auto d-flex gap-2 flex-wrap">
                <button class="btn-control btn-success" onclick="setSirine('ON')">🟢 Hidupkan Sirine</button>
                <button class="btn-control btn-danger" onclick="setSirine('OFF')">🔴 Matikan Sirine</button>
                <button class="btn-control btn-secondary" onclick="setSirine('AUTO')">⚙️ Mode Otomatis</button>
            </div>
        </div>
        <small id="mode-info" class="text-muted fst-italic mt-2 d-block">Mode: sinkronisasi...</small>
    </div>

    {{-- 📸 FOTO KONDISI --}}
    <div class="mb-4">
        <h4 class="section-title">📷 Foto Kondisi Terakhir</h4>
        <div id="foto-kondisi" class="text-center">
            <p class="loading">Loading foto kondisi...</p>
        </div>
    </div>

    {{-- 📨 DISTRIBUSI NOTIFIKASI --}}
    <div>
        <h4 class="section-title">📨 Distribusi Notifikasi</h4>
        <table class="table table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Device</th>
                    <th>Lantai</th>
                    <th>Event</th>
                    <th>Status</th>
                    <th>Pesan</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody id="table-distribusi">
                <tr><td colspan="7" class="text-muted">Belum ada data.</td></tr>
            </tbody>
        </table>
    </div>
</div>

<audio id="alarm-sound" src="{{ asset('alarm.mp3') }}" preload="auto"></audio>
<div id="alert-popup"></div>
<div id="sse-indicator" class="inactive">⚫ SSE Nonaktif</div>

<script>
let evtSource = null;
let sseActive = false;
let eventCooldown = false;

// ================== SSE MANUAL CONTROL ===================
function toggleSSE() {
    const btn = document.getElementById('toggle-sse');
    const indicator = document.getElementById('sse-indicator');

    if (!sseActive) {
        evtSource = new EventSource("{{ route('dashboard.sse') }}");
        evtSource.addEventListener("update", function(event) {
            if (eventCooldown) return;
            const data = JSON.parse(event.data);
            updateNotification(data);
            if (data.event_type === "SMOKE" || data.event_type === "FIRE") {
                playAlarmSound();
                showPopupAlert(data.event_type);
            }
        });
        sseActive = true;
        indicator.className = "active";
        indicator.textContent = "🟢 SSE Aktif";
        btn.textContent = "⛔ Hentikan SSE";
        alert("✅ SSE diaktifkan. Sekarang sistem siap menerima event SMOKE/FIRE.");
    } else {
        evtSource.close();
        evtSource = null;
        sseActive = false;
        indicator.className = "inactive";
        indicator.textContent = "⚫ SSE Nonaktif";
        btn.textContent = "🧪 Tes SSE";
        stopAlarmSound();
        setSirine('OFF', true);
        alert("🛑 SSE dimatikan. Tidak ada event yang akan diterima.");
    }
}

// 🔔 Update area notifikasi
function updateNotification(data) {
    document.getElementById("notif-area").innerHTML = `
        <div class="alert alert-danger alert-box">
            🚨 <b>${data.event_type}</b> terdeteksi di <b>${data.device_id}</b> (Lantai ${data.floor})<br>
            Nilai: ${data.value}<br>
            <small>${data.timestamp}</small><br><br>
            <button class="btn btn-sm btn-primary me-2" onclick="ackEvent(${data.id})">✅ ACK</button>
            <button class="btn btn-sm btn-success" onclick="resolveEvent(${data.id})">🆗 RESOLVE</button>
        </div>
    `;
}

// ================== SIRINE CONTROL (FAST RESPONSE FIX) ===================
function setSirine(mode, silent = false) {
    const el = document.getElementById('sirine-status');
    // Langsung update status secara visual dulu (respons cepat)
    el.textContent = mode;
    el.className = 'badge fs-6 p-2 ' + (mode === 'ON' ? 'bg-danger' : 'bg-secondary');
    document.getElementById('mode-info').textContent = "Mode: " + mode;

    if (mode === 'OFF') stopAlarmSound();

    fetch('/api/control', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({status: mode})
    }).then(() => {
        if (!silent) loadSirineStatus(); // sinkronisasi status real
    }).catch(() => {
        if (!silent) alert("⚠️ Gagal mengirim perintah sirine, cek koneksi server.");
    });
}

function loadSirineStatus() {
    fetch('/api/control')
        .then(res => res.text())
        .then(status => {
            const el = document.getElementById('sirine-status');
            el.textContent = status.trim();
            el.className = 'badge fs-6 p-2 ' +
                (status.trim() === 'ON' ? 'bg-danger' :
                 status.trim() === 'OFF' ? 'bg-secondary' : 'bg-success');
            document.getElementById('mode-info').textContent = "Mode: " + status.trim();
        });
}
document.addEventListener("DOMContentLoaded", loadSirineStatus);

// ================== ALARM SOUND ===================
function playAlarmSound() {
    const sound = document.getElementById('alarm-sound');
    sound.play();
}
function stopAlarmSound() {
    const sound = document.getElementById('alarm-sound');
    sound.pause();
    sound.currentTime = 0;
}

// ================== POPUP ALERT ===================
function showPopupAlert(type) {
    const popup = document.getElementById('alert-popup');
    popup.style.display = 'block';
    popup.style.background = type === 'SMOKE' ? 'rgba(220,0,0,0.9)' : 'rgba(255,165,0,0.9)';
    popup.innerHTML = type === 'SMOKE'
        ? '🚨 PERINGATAN: Terdeteksi Asap di Asrama!'
        : '🚨 PERINGATAN: Terdeteksi Api di Asrama!';
    setTimeout(() => { popup.style.display = 'none'; }, 8000);
}

// ================== ACK / RESOLVE ===================
function ackEvent(id) {
    fetch(`/api/riwayat/${id}/ack`, { method: 'POST' })
        .then(() => {
            setSirine('OFF');
            stopAlarmSound();
            eventCooldown = true;
            setTimeout(() => { eventCooldown = false; }, 5000);
            if (evtSource) toggleSSE(); // matikan SSE otomatis
            alert("✅ Event diakui (ACK) dan SSE dimatikan.");
        });
}
function resolveEvent(id) {
    fetch(`/api/riwayat/${id}/resolve`, { method: 'POST' })
        .then(() => {
            setSirine('OFF');
            stopAlarmSound();
            eventCooldown = true;
            setTimeout(() => { eventCooldown = false; }, 5000);
            if (evtSource) toggleSSE();
            alert("🆗 Event diselesaikan, sirine dimatikan dan SSE dihentikan.");
        });
}
</script>
@endsection
