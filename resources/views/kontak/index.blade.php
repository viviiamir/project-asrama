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
            <h2 class="fw-bold mb-4">☎️ Kontak Darurat</h2>
            <p class="text-muted mb-4">Hubungi layanan darurat berikut secara langsung melalui panggilan atau WhatsApp:</p>

            <a href="{{ route('kontak.create') }}" class="btn btn-primary mb-3">➕ Tambah Kontak</a>

            <div class="list-group">
                @foreach($kontaks as $kontak)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        {{ $kontak->ikon }} <strong>{{ $kontak->nama }}</strong><br>
                        <small class="text-muted">Nomor: {{ $kontak->nomor }}</small>
                    </div>
                    <div>
                        <a href="tel:{{ $kontak->nomor }}" class="btn btn-danger btn-sm rounded-pill px-3">📞 Panggil</a>
                        <a href="https://wa.me/{{ $kontak->whatsapp }}?text={{ urlencode($kontak->pesan_wa) }}"
                           class="btn btn-success btn-sm rounded-pill px-3" target="_blank">💬 WhatsApp</a>
                        <a href="{{ route('kontak.edit', $kontak->id) }}" class="btn btn-warning btn-sm rounded-pill px-3">✏️ Edit</a>
                        <form action="{{ route('kontak.destroy', $kontak->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3" onclick="return confirm('Yakin hapus kontak ini?')">🗑️ Hapus</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
