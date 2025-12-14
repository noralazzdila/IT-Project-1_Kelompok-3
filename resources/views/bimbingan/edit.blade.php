@extends('layouts.app')

@section('title', 'Edit Data Bimbingan')

@section('content')
<div class="card shadow-sm p-4">
    <h5 class="fw-bold mb-3">Formulir Edit Bimbingan</h5>
    
    <form action="{{ route('bimbingan.update', $bimbingan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="mahasiswa_nama" class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control @error('mahasiswa_nama') is-invalid @enderror" id="mahasiswa_nama" name="mahasiswa_nama" value="{{ old('mahasiswa_nama', $bimbingan->mahasiswa_nama) }}" required>
            @error('mahasiswa_nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="nim" class="form-label">NIM</label>
            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $bimbingan->nim) }}" required>
            @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="dosen_pembimbing" class="form-label">Dosen Pembimbing</label>
            <input type="text" class="form-control @error('dosen_pembimbing') is-invalid @enderror" id="dosen_pembimbing" name="dosen_pembimbing" value="{{ old('dosen_pembimbing', $bimbingan->dosen_pembimbing) }}" required>
            @error('dosen_pembimbing')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="tanggal_bimbingan" class="form-label">Tanggal Bimbingan</label>
            <input type="date" class="form-control @error('tanggal_bimbingan') is-invalid @enderror" id="tanggal_bimbingan" name="tanggal_bimbingan" value="{{ old('tanggal_bimbingan', $bimbingan->tanggal_bimbingan->format('Y-m-d')) }}" required>
            @error('tanggal_bimbingan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="topik_bimbingan" class="form-label">Topik Bimbingan</label>
            <input type="text" class="form-control @error('topik_bimbingan') is-invalid @enderror" id="topik_bimbingan" name="topik_bimbingan" value="{{ old('topik_bimbingan', $bimbingan->topik_bimbingan) }}" required>
            @error('topik_bimbingan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="4" required>{{ old('catatan', $bimbingan->catatan) }}</textarea>
            @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                <option value="Menunggu" {{ old('status', $bimbingan->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Disetujui" {{ old('status', $bimbingan->status) == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="Revisi" {{ old('status', $bimbingan->status) == 'Revisi' ? 'selected' : '' }}>Revisi</option>
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('bimbingan.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection