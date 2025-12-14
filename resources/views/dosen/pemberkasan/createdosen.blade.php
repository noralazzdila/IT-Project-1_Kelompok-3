@extends('dosen.layouts.app')

@section('title', 'Tambah Data Pemberkasan')

@section('header-title', 'Tambah Data Pemberkasan')

@section('content')
<div class="card shadow-sm p-4">
    <h5 class="fw-bold mb-3">Formulir Pemberkasan Baru</h5>
    
    <form action="{{ route('dosen.pemberkasan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="mahasiswa_id" class="form-label">ID Mahasiswa</label>
            <input type="number" class="form-control @error('mahasiswa_id') is-invalid @enderror" id="mahasiswa_id" name="mahasiswa_id" value="{{ old('mahasiswa_id') }}" required>
            <small class="text-muted">Masukkan ID dari mahasiswa yang bersangkutan.</small>
            @error('mahasiswa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="form_bimbingan_path" class="form-label">Form Bimbingan (PDF)</label>
            <input type="file" class="form-control @error('form_bimbingan_path') is-invalid @enderror" id="form_bimbingan_path" name="form_bimbingan_path" accept=".pdf">
            @error('form_bimbingan_path')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-3">
            <label for="sertifikat_path" class="form-label">Sertifikat PKL (PDF)</label>
            <input type="file" class="form-control @error('sertifikat_path') is-invalid @enderror" id="sertifikat_path" name="sertifikat_path" accept=".pdf">
            @error('sertifikat_path')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="laporan_final_path" class="form-label">Laporan Final (PDF)</label>
            <input type="file" class="form-control @error('laporan_final_path') is-invalid @enderror" id="laporan_final_path" name="laporan_final_path" accept=".pdf">
            @error('laporan_final_path')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_verifikasi" class="form-label">Tanggal Verifikasi</label>
            <input type="date" class="form-control @error('tanggal_verifikasi') is-invalid @enderror" id="tanggal_verifikasi" name="tanggal_verifikasi" value="{{ old('tanggal_verifikasi') }}">
            @error('tanggal_verifikasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Status Kelengkapan</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="is_lengkap" id="lengkap" value="1" {{ old('is_lengkap') == '1' ? 'checked' : '' }}>
                <label class="form-check-label" for="lengkap">Lengkap</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="is_lengkap" id="belum_lengkap" value="0" {{ old('is_lengkap', '0') == '0' ? 'checked' : '' }}>
                <label class="form-check-label" for="belum_lengkap">Belum Lengkap</label>
            </div>
            @error('is_lengkap')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('dosen.pemberkasan.indexdosen') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        </div>
    </form>
</div>
@endsection
