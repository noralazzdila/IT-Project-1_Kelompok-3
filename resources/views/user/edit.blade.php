@extends('layouts.app')

@section('title', 'Edit Data User')

@section('content')
<div class="card shadow-sm p-4">
    <h6 class="fw-bold mb-3"><i class="fa fa-user-edit me-2"></i> Form Edit User</h6>

    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Password Baru (Opsional)</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Role / Hak Akses</label>
            <select name="role" class="form-select" required>
                <option value="koordinator" {{ $user->role == 'koordinator' ? 'selected' : '' }}>Koordinator PKL</option>
                <option value="dosen" {{ $user->role == 'dosen' ? 'selected' : '' }}>Dosen</option>
                <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                <option value="kaprodi" {{ $user->role == 'kaprodi' ? 'selected' : '' }}>Kepala Program Studi</option>
                <option value="mahasiswa" {{ $user->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">NIP / NIM</label>
            <input type="text" name="identifier" class="form-control" value="{{ old('identifier', $user->identifier) }}" placeholder="Opsional (jika ada)">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-select" required>
                <option value="aktif" {{ $user->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ $user->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save me-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection