@extends('dosen.layouts.app')

@section('title', 'Tambah Data Mahasiswa')

@section('header-title', 'Tambah Data Mahasiswa')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dosen.datamahasiswa.index') }}">Kelola Mahasiswa</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Mahasiswa</li>
    </ol>
</nav>

<div class="card rounded-3 shadow-sm border-0">
    <div class="card-header text-white" style="background-color: #113F67;">
        <h5 class="mb-0"><i class="fa-solid fa-user-plus me-2"></i>Form Tambah Mahasiswa</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('dosen.datamahasiswa.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}" required>
                    @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <div class="mt-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="laki">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                            <label class="form-check-label" for="perempuan">Perempuan</label>
                        </div>
                    </div>
                    @error('jenis_kelamin')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                    @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <input type="text" class="form-control @error('prodi') is-invalid @enderror" id="prodi" name="prodi" value="{{ old('prodi') }}" required>
                    @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" value="{{ old('kelas') }}" required>
                    @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tahun_angkatan" class="form-label">Tahun Angkatan</label>
                    <input type="number" class="form-control @error('tahun_angkatan') is-invalid @enderror" id="tahun_angkatan" name="tahun_angkatan" value="{{ old('tahun_angkatan') }}" placeholder="YYYY" required>
                    @error('tahun_angkatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="dosen_pembimbing" class="form-label">Dosen Pembimbing</label>
                <input type="text" class="form-control @error('dosen_pembimbing') is-invalid @enderror" id="dosen_pembimbing" name="dosen_pembimbing" value="{{ old('dosen_pembimbing') }}" required>
                @error('dosen_pembimbing')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="tempat_pkl" class="form-label">Tempat PKL</label>
                <input type="text" class="form-control @error('tempat_pkl') is-invalid @enderror" id="tempat_pkl" name="tempat_pkl" value="{{ old('tempat_pkl') }}" required>
                @error('tempat_pkl')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="status_pkl" class="form-label">Status PKL</label>
                    <select class="form-select @error('status_pkl') is-invalid @enderror" id="status_pkl" name="status_pkl" required>
                        <option value="Belum Mulai" {{ old('status_pkl') == 'Belum Mulai' ? 'checked' : '' }}>Belum Mulai</option>
                        <option value="Sedang PKL" {{ old('status_pkl') == 'Sedang PKL' ? 'checked' : '' }}>Sedang PKL</option>
                        <option value="Selesai" {{ old('status_pkl') == 'Selesai' ? 'checked' : '' }}>Selesai</option>
                    </select>
                    @error('status_pkl')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="no_hp" class="form-label">No. HP</label>
                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                    @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('dosen.datamahasiswa.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save me-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection