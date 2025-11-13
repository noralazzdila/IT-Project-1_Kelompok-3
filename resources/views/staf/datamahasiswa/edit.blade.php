@extends('staf.layouts.app')

@section('title', 'Edit Data Mahasiswa - Staf')

@section('header-title', 'Edit Data Mahasiswa')

@section('content')
<div class="container mt-4 flex-grow-1">
    <div class="card shadow-sm p-4">
        <h5 class="fw-bold mb-3">Formulir Edit Data Mahasiswa</h5>
        
        <form action="{{ route('staf.datamahasiswa.update', $datamahasiswa->id) }}" method="POST">
            @csrf
            @method('PUT')
             <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $datamahasiswa->nama) }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
             <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $datamahasiswa->nim) }}" required>
                    @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <div class="mt-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki" value="Laki-laki" {{ old('jenis_kelamin', $datamahasiswa->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="laki-laki">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" {{ old('jenis_kelamin', $datamahasiswa->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                            <label class="form-check-label" for="perempuan">Perempuan</label>
                        </div>
                    </div>
                    @error('jenis_kelamin')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                     <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $datamahasiswa->tanggal_lahir ? $datamahasiswa->tanggal_lahir->format('Y-m-d') : '') }}" required>
                    @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                     <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $datamahasiswa->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
             <hr>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <input type="text" class="form-control @error('prodi') is-invalid @enderror" id="prodi" name="prodi" value="{{ old('prodi', $datamahasiswa->prodi) }}" required>
                    @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" value="{{ old('kelas', $datamahasiswa->kelas) }}" required>
                    @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="tahun_angkatan" class="form-label">Tahun Angkatan</label>
                    <input type="number" class="form-control @error('tahun_angkatan') is-invalid @enderror" id="tahun_angkatan" name="tahun_angkatan" value="{{ old('tahun_angkatan', $datamahasiswa->tahun_angkatan) }}" placeholder="YYYY" required>
                    @error('tahun_angkatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

             <div class="mb-3">
                <label for="dosen_pembimbing" class="form-label">Dosen Pembimbing</label>
                <select class="form-select @error('dosen_pembimbing') is-invalid @enderror" id="dosen_pembimbing" name="dosen_pembimbing" required>
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
                <input type="text" class="form-control @error('tempat_pkl') is-invalid @enderror" id="tempat_pkl" name="tempat_pkl" value="{{ old('tempat_pkl', $datamahasiswa->tempat_pkl) }}" required>
                @error('tempat_pkl')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="status_pkl" class="form-label">Status PKL</label>
                    <select class="form-select @error('status_pkl') is-invalid @enderror" id="status_pkl" name="status_pkl" required>
                        <option value="Belum Mulai" {{ old('status_pkl', $datamahasiswa->status_pkl) == 'Belum Mulai' ? 'selected' : '' }}>Belum Mulai</option>
                        <option value="Sedang PKL" {{ old('status_pkl', $datamahasiswa->status_pkl) == 'Sedang PKL' ? 'selected' : '' }}>Sedang PKL</option>
                        <option value="Selesai" {{ old('status_pkl', $datamahasiswa->status_pkl) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status_pkl')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="no_hp" class="form-label">No. HP</label>
                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $datamahasiswa->no_hp) }}" required>
                    @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('staf.datamahasiswa.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
