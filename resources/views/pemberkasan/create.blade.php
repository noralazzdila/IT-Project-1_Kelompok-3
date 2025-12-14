@extends('layouts.app')

@section('title', 'Tambah Pemberkasan')

@section('content')
<div class="card shadow-sm p-4">
    <h6 class="fw-bold mb-3">Formulir Upload Pemberkasan</h6>
    
    {{-- FORM: Diperlukan enctype="multipart/form-data" untuk upload file --}}
    <form action="{{ route('pemberkasan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- Dropdown Mahasiswa --}}
        <div class="mb-3">
            <label for="mahasiswa_id" class="form-label fw-bold">Mahasiswa <span class="text-danger">*</span></label>
            {{-- Pastikan variabel $mahasiswas dikirim dari Controller --}}
            <select class="form-select @error('mahasiswa_id') is-invalid @enderror" id="mahasiswa_id" name="mahasiswa_id" required>
                <option value="" selected disabled>-- Pilih Mahasiswa --</option>
                {{-- Data Mahasiswa, sesuaikan dengan nama variabel Anda --}}
                @isset($mahasiswas)
                    @foreach ($mahasiswas as $mhs)
                        <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                            {{ $mhs->nim }} - {{ $mhs->nama }}
                        </option>
                    @endforeach
                @endisset
            </select>
            @error('mahasiswa_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <hr>
        <p class="fw-bold text-muted">Upload Dokumen (PDF only, max 5MB per file)</p>

        {{-- Input Form Bimbingan --}}
        <div class="mb-3">
            <label for="form_bimbingan" class="form-label">Form Bimbingan</label>
            <input class="form-control @error('form_bimbingan') is-invalid @enderror" type="file" id="form_bimbingan" name="form_bimbingan" accept=".pdf">
            @error('form_bimbingan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Sertifikat --}}
        <div class="mb-3">
            <label for="sertifikat" class="form-label">Sertifikat PKL</label>
            <input class="form-control @error('sertifikat') is-invalid @enderror" type="file" id="sertifikat" name="sertifikat" accept=".pdf">
            @error('sertifikat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Laporan Final --}}
        <div class="mb-4">
            <label for="laporan_final" class="form-label">Laporan Final</label>
            <input class="form-control @error('laporan_final') is-invalid @enderror" type="file" id="laporan_final" name="laporan_final" accept=".pdf">
            @error('laporan_final')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('pemberkasan.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Simpan Pemberkasan
            </button>
        </div>
    </form>
</div>
@endsection