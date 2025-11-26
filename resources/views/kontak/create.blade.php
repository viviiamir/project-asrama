@extends('layouts.app')
@section('title', 'Tambah Kontak')
@section('content')

<div class="container mt-5">
    <div class="card p-4 shadow-lg rounded-4">
        <h3>Tambah Kontak Darurat</h3>
        <form action="{{ route('kontak.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama Layanan</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nomor Telepon</label>
                <input type="text" name="nomor" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nomor WhatsApp</label>
                <input type="text" name="whatsapp" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Pesan Otomatis WhatsApp</label>
                <textarea name="pesan_wa" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label>Ikon (emoji)</label>
                <input type="text" name="ikon" class="form-control" placeholder="Contoh: 🚑">
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">💾 Simpan</button>
            <a href="{{ route('kontak.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
