@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
<div class="card shadow-sm p-4">
    <h6 class="fw-bold mb-3"><i class="fa fa-user-plus me-2"></i> Form Tambah User</h6>

    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Role / Hak Akses</label>
            <select name="role" class="form-select" required>
                <option value="" selected disabled>Pilih Role</option>
                <option value="koordinator">Koordinator PKL</option>
                <option value="dosen">Dosen</option>
                <option value="staff">Staff</option>
                <option value="kaprodi">Kepala Program Studi</option>
                <option value="mahasiswa">Mahasiswa</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">NIP / NIM</label>
            <input type="text" name="identifier" class="form-control" placeholder="Opsional (jika ada)">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select" required>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection