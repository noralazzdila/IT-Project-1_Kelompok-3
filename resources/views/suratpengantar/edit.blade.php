@extends('layouts.app')

@section('title', 'Edit Surat Pengantar')

@section('content')
<div class="card shadow-sm p-4">
    <h5 class="fw-bold mb-3">Formulir Edit Surat Pengantar</h5>
    
    <form action="{{ route('suratpengantar.update', $suratpengantar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $suratpengantar->nim) }}" required>
                @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control @error('nama_mahasiswa') is-invalid @enderror" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ old('nama_mahasiswa', $suratpengantar->nama_mahasiswa) }}" required>
                @error('nama_mahasiswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="prodi" class="form-label">Program Studi</label>
            <input type="text" class="form-control @error('prodi') is-invalid @enderror" id="prodi" name="prodi" value="{{ old('prodi', $suratpengantar->prodi) }}" required>
            @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="tempat_pkl" class="form-label">Tempat PKL</label>
            <input type="text" class="form-control @error('tempat_pkl') is-invalid @enderror" id="tempat_pkl" name="tempat_pkl" value="{{ old('tempat_pkl', $suratpengantar->tempat_pkl) }}" required>
            @error('tempat_pkl')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="alamat_perusahaan" class="form-label">Alamat Perusahaan</label>
            <textarea class="form-control @error('alamat_perusahaan') is-invalid @enderror" id="alamat_perusahaan" name="alamat_perusahaan" rows="3" required>{{ old('alamat_perusahaan', $suratpengantar->alamat_perusahaan) }}</textarea>
            @error('alamat_perusahaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                <input type="date" class="form-control @error('tanggal_pengajuan') is-invalid @enderror" id="tanggal_pengajuan" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', $suratpengantar->tanggal_pengajuan) }}" required>
                @error('tanggal_pengajuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="Menunggu" {{ old('status', $suratpengantar->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diproses" {{ old('status', $suratpengantar->status) == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ old('status', $suratpengantar->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="file_surat" class="form-label">Upload File Baru (PDF, maks. 5MB)</label>
            <input class="form-control @error('file_surat') is-invalid @enderror" type="file" id="file_surat" name="file_surat">
            <div class="form-text">Biarkan kosong jika tidak ingin mengubah file.</div>
            @error('file_surat')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan', $suratpengantar->catatan) }}</textarea>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('suratpengantar.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection