@extends('dosen.layouts.app')

@section('title', 'Edit Data Pemberkasan')

@section('header-title', 'Edit Data Pemberkasan')

@section('content')
<div class="card shadow-sm p-4">
    <h5 class="fw-bold mb-3">Formulir Edit Pemberkasan</h5>
    
    <form action="{{ route('dosen.pemberkasan.updatedosen', $pemberkasan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
            <input type="text" class="form-control" id="mahasiswa_name" name="mahasiswa_name" value="{{ $pemberkasan->mahasiswa->nama ?? 'ID: ' . $pemberkasan->mahasiswa_id }}" disabled>
            <input type="hidden" name="mahasiswa_id" value="{{ $pemberkasan->mahasiswa_id }}">
            <small class="text-muted">Mahasiswa tidak dapat diubah.</small>
        </div>

        <div class="mb-3">
            <label for="form_bimbingan_path" class="form-label">Form Bimbingan (PDF)</label>
            <input type="file" class="form-control @error('form_bimbingan_path') is-invalid @enderror" id="form_bimbingan_path" name="form_bimbingan_path" accept=".pdf">
            @if($pemberkasan->form_bimbingan_path)
                <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $pemberkasan->form_bimbingan_path) }}" target="_blank">Lihat File</a></small>
            @endif
            @error('form_bimbingan_path')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-3">
            <label for="sertifikat_path" class="form-label">Sertifikat PKL (PDF)</label>
            <input type="file" class="form-control @error('sertifikat_path') is-invalid @enderror" id="sertifikat_path" name="sertifikat_path" accept=".pdf">
            @if($pemberkasan->sertifikat_path)
                <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $pemberkasan->sertifikat_path) }}" target="_blank">Lihat File</a></small>
            @endif
            @error('sertifikat_path')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="laporan_final_path" class="form-label">Laporan Final (PDF)</label>
            <input type="file" class="form-control @error('laporan_final_path') is-invalid @enderror" id="laporan_final_path" name="laporan_final_path" accept=".pdf">
            @if($pemberkasan->laporan_final_path)
                <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $pemberkasan->laporan_final_path) }}" target="_blank">Lihat File</a></small>
            @endif
            @error('laporan_final_path')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_verifikasi" class="form-label">Tanggal Verifikasi</label>
            <input type="date" class="form-control @error('tanggal_verifikasi') is-invalid @enderror" id="tanggal_verifikasi" name="tanggal_verifikasi" value="{{ old('tanggal_verifikasi', $pemberkasan->tanggal_verifikasi ? \Carbon\Carbon::parse($pemberkasan->tanggal_verifikasi)->format('Y-m-d') : '') }}">
            @error('tanggal_verifikasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Status Kelengkapan</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="is_lengkap" id="lengkap" value="1" {{ old('is_lengkap', $pemberkasan->is_lengkap) == '1' ? 'checked' : '' }}>
                <label class="form-check-label" for="lengkap">Lengkap</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="is_lengkap" id="belum_lengkap" value="0" {{ old('is_lengkap', $pemberkasan->is_lengkap) == '0' ? 'checked' : '' }}>
                <label class="form-check-label" for="belum_lengkap">Belum Lengkap</label>
            </div>
            @error('is_lengkap')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('dosen.pemberkasan.indexdosen') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
