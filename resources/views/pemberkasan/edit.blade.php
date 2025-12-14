@extends('layouts.app')

@section('title', 'Edit Pemberkasan')

@section('content')
<div class="card shadow-sm p-4">
    <h6 class="fw-bold mb-3">Formulir Edit Pemberkasan</h6>

    {{-- FORM EDIT --}}
    <form action="{{ route('pemberkasan.update', $pemberkasan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Dropdown Mahasiswa --}}
        <div class="mb-3">
            <label for="mahasiswa_id" class="form-label fw-bold">Mahasiswa <span class="text-danger">*</span></label>
            <select class="form-select @error('mahasiswa_id') is-invalid @enderror" id="mahasiswa_id" name="mahasiswa_id" required>
                <option value="" disabled>-- Pilih Mahasiswa --</option>
                @foreach ($mahasiswas as $mhs)
                    <option value="{{ $mhs->id }}" {{ $pemberkasan->mahasiswa_id == $mhs->id ? 'selected' : '' }}>
                        {{ $mhs->nim }} - {{ $mhs->nama }}
                    </option>
                @endforeach
            </select>
            @error('mahasiswa_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <hr>
        <p class="fw-bold text-muted">Upload Dokumen Baru (PDF only, max 5MB per file)</p>
        <small class="text-muted">*Kosongkan jika tidak ingin mengganti file.</small>

        {{-- Form Bimbingan --}}
        <div class="mb-3">
            <label for="form_bimbingan" class="form-label">Form Bimbingan</label>
            @if ($pemberkasan->form_bimbingan)
                <p class="mb-1"><a href="{{ route('pemberkasan.file', ['pemberkasan' => $pemberkasan, 'field' => 'form_bimbingan']) }}" target="_blank"><i class="fa fa-file-pdf text-danger me-1"></i> Lihat File Lama</a></p>
            @endif
            <input class="form-control @error('form_bimbingan') is-invalid @enderror" type="file" id="form_bimbingan" name="form_bimbingan" accept=".pdf">
            @error('form_bimbingan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Sertifikat --}}
        <div class="mb-3">
            <label for="sertifikat" class="form-label">Sertifikat PKL</label>
            @if ($pemberkasan->sertifikat)
                <p class="mb-1"><a href="{{ route('pemberkasan.file', ['pemberkasan' => $pemberkasan, 'field' => 'sertifikat']) }}" target="_blank"><i class="fa fa-file-pdf text-danger me-1"></i> Lihat File Lama</a></p>
            @endif
            <input class="form-control @error('sertifikat') is-invalid @enderror" type="file" id="sertifikat" name="sertifikat" accept=".pdf">
            @error('sertifikat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Laporan Final --}}
        <div class="mb-4">
            <label for="laporan_final" class="form-label">Laporan Final</label>
            @if ($pemberkasan->laporan_final)
                <p class="mb-1"><a href="{{ route('pemberkasan.file', ['pemberkasan' => $pemberkasan, 'field' => 'laporan_final']) }}" target="_blank"><i class="fa fa-file-pdf text-danger me-1"></i> Lihat File Lama</a></p>
            @endif
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
                <i class="fa fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection