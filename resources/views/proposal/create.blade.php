@extends('layouts.app')

@section('title', 'Tambah Proposal PKL')

@section('content')
<div class="card shadow-sm p-4">
    <h5 class="fw-bold mb-3">Formulir Proposal PKL Baru</h5>
    
    <form action="{{ route('proposal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
             <label for="nim" class="form-label">NIM</label>
             <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}" required>
             @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control @error('nama_mahasiswa') is-invalid @enderror" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" required>
            @error('nama_mahasiswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="judul_proposal" class="form-label">Judul Proposal</label>
            <input type="text" class="form-control @error('judul_proposal') is-invalid @enderror" id="judul_proposal" name="judul_proposal" value="{{ old('judul_proposal') }}" required>
            @error('judul_proposal')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="pembimbing" class="form-label">Dosen Pembimbing</label>
             <select class="form-select @error('pembimbing') is-invalid @enderror" id="pembimbing" name="pembimbing" required>
             <option value="">Pilih Dosen Pembimbing</option>
             @php
            // Ambil data dosen langsung di view (sementara)
            $dosens = \App\Models\Dosen::orderBy('nama')->get();
              @endphp
              @foreach($dosens as $dosen)
             <option value="{{ $dosen->id }}" {{ old('dosen_pembimbing') == $dosen->id ? 'selected' : '' }}>
                {{ $dosen->nama }} - {{ $dosen->nip }}
             </option>
             @endforeach
            </select>
             @error('dosen_pembimbing')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        <div class="mb-3">
            <label for="tempat_pkl" class="form-label">Tempat PKL</label>
            <input type="text" class="form-control @error('tempat_pkl') is-invalid @enderror" id="tempat_pkl" name="tempat_pkl" value="{{ old('tempat_pkl') }}" required>
            @error('tempat_pkl')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        
        <div class="mb-3">
            <label for="file_proposal" class="form-label">Upload File Proposal (PDF, maks. 5MB)</label>
            <input class="form-control @error('file_proposal') is-invalid @enderror" type="file" id="file_proposal" name="file_proposal" required>
            @error('file_proposal')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
            <input type="date" class="form-control @error('tanggal_pengajuan') is-invalid @enderror" id="tanggal_pengajuan" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', date('Y-m-d')) }}" required>
            @error('tanggal_pengajuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                <option value="Menunggu" {{ old('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Disetujui" {{ old('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="Ditolak" {{ old('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
             @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan (Opsional)</label>
            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
            @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('proposal.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        </div>
    </form>
</div>
@endsection