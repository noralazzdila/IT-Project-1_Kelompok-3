@extends('koorprodi.layouts.app')

@section('title', 'Edit Proposal - Koordinator Prodi')

@section('header-title', 'Edit Proposal')

@section('content')
<div class="container mt-4 flex-grow-1">
    <div class="card shadow-sm p-4">
        <h5 class="fw-bold mb-3">Formulir Edit Proposal PKL</h5>
        
        <form action="{{ route('koorprodi.proposal.update', $proposal->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $proposal->nim) }}" required>
                @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control @error('nama_mahasiswa') is-invalid @enderror" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ old('nama_mahasiswa', $proposal->nama_mahasiswa) }}" required>
                @error('nama_mahasiswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="judul_proposal" class="form-label">Judul Proposal</label>
                <input type="text" class="form-control @error('judul_proposal') is-invalid @enderror" id="judul_proposal" name="judul_proposal" value="{{ old('judul_proposal', $proposal->judul_proposal) }}" required>
                @error('judul_proposal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="pembimbing" class="form-label">Dosen Pembimbing</label>
                <input type="text" class="form-control @error('pembimbing') is-invalid @enderror" id="pembimbing" name="pembimbing" value="{{ old('pembimbing', $proposal->pembimbing) }}" required>
                @error('pembimbing')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="tempat_pkl" class="form-label">Tempat PKL</label>
                <input type="text" class="form-control @error('tempat_pkl') is-invalid @enderror" id="tempat_pkl" name="tempat_pkl" value="{{ old('tempat_pkl', $proposal->tempat_pkl) }}" required>
                @error('tempat_pkl')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-3">
                <label for="file_proposal" class="form-label">Upload File Baru (Opsional)</label>
                <input class="form-control @error('file_proposal') is-invalid @enderror" type="file" id="file_proposal" name="file_proposal">
                <div class="form-text">Biarkan kosong jika tidak ingin mengubah file proposal.</div>
                @error('file_proposal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                <input type="date" class="form-control @error('tanggal_pengajuan') is-invalid @enderror" id="tanggal_pengajuan" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', $proposal->tanggal_pengajuan) }}" required>
                @error('tanggal_pengajuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="Menunggu" {{ old('status', $proposal->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Disetujui" {{ old('status', $proposal->status) == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Ditolak" {{ old('status', $proposal->status) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                 @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3">{{ old('catatan', $proposal->catatan) }}</textarea>
                @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('koorprodi.proposal.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
