@extends('layouts.app')
@section('title', 'Edit Kontak')
@section('content')

<div class="container mt-5">
    <div class="card p-4 shadow-lg rounded-4">
        <h3>Edit Kontak Darurat</h3>
        <form action="{{ route('kontak.update', $kontak->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Nama Layanan</label>
                <input type="text" name="nama" class="form-control" value="{{ $kontak->nama }}" required>
            </div>
            <div class="mb-3">
                <label>Nomor Telepon</label>
                <input type="text" name="nomor" class="form-control" value="{{ $kontak->nomor }}" required>
            </div>
            <div class="mb-3">
                <label>Nomor WhatsApp</label>
                <input type="text" name="whatsapp" class="form-control" value="{{ $kontak->whatsapp }}" required>
            </div>
            <div class="mb-3">
                <label>Pesan Otomatis WhatsApp</label>
                <textarea name="pesan_wa" class="form-control" required>{{ $kontak->pesan_wa }}</textarea>
            </div>
            <div class="mb-3">
                <label>Ikon (emoji)</label>
                <input type="text" name="ikon" class="form-control" value="{{ $kontak->ikon }}">
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="aktif" {{ $kontak->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $kontak->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-warning">🔄 Update</button>
            <a href="{{ route('kontak.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
