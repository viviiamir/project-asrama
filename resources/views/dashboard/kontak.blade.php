@extends('layouts.app')
@section('title', 'Kontak Darurat')
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
        <div class="card-body text-center">
            <h2 class="fw-bold mb-4">
                ☎️ Kontak Darurat
            </h2>
            <p class="text-muted mb-4">Hubungi layanan darurat berikut secara langsung melalui panggilan atau WhatsApp:</p>

            <div class="list-group">
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        🚑 <strong>Ambulans</strong><br>
                        <small class="text-muted">Nomor: 118</small>
                    </div>
                    <div>
                        <a href="tel:118" class="btn btn-danger btn-sm rounded-pill px-3">📞 Panggil</a>
                        <a href="https://wa.me/6281234567890?text=Halo%20Ambulans,%20ada%20keadaan%20darurat!"
                           class="btn btn-success btn-sm rounded-pill px-3" target="_blank">💬 WhatsApp</a>
                    </div>
                </div>

                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        🔥 <strong>Pemadam Kebakaran</strong><br>
                        <small class="text-muted">Nomor: 113</small>
                    </div>
                    <div>
                        <a href="tel:113" class="btn btn-danger btn-sm rounded-pill px-3">📞 Panggil</a>
                        <a href="https://wa.me/6289876543210?text=Halo%20Pemadam,%20terjadi%20kebakaran!"
                           class="btn btn-success btn-sm rounded-pill px-3" target="_blank">💬 WhatsApp</a>
                    </div>
                </div>

                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        👮 <strong>Keamanan</strong><br>
                        <small class="text-muted">Nomor: 110</small>
                    </div>
                    <div>
                        <a href="tel:110" class="btn btn-danger btn-sm rounded-pill px-3">📞 Panggil</a>
                        <a href="https://wa.me/6282236060717?text=Halo%20Keamanan,%20ada%20gangguan%20di%20asrama!"
                           class="btn btn-success btn-sm rounded-pill px-3" target="_blank">💬 WhatsApp</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
