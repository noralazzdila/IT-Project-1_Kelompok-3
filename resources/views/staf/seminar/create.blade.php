@extends('staf.layouts.app')

@section('title', 'Tambah Jadwal Seminar')

@section('header-title', 'Tambah Jadwal Seminar')

@section('content')
<div class="card shadow-sm p-4">
    <h5 class="fw-bold mb-3">Formulir Jadwal Seminar Baru</h5>
    
    <form action="{{ route('staf.seminar.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control @error('nama_mahasiswa') is-invalid @enderror" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" required>
            @error('nama_mahasiswa')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
           <label for="nim" class="form-label">NIM</label>
           <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}" required>
            @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
           <label for="judul" class="form-label">Judul Laporan/Seminar</label>
           <textarea class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" rows="3" required>{{ old('judul') }}</textarea>
            @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
         <div class="mb-3">
           <label for="nama_pembimbing" class="form-label">Dosen Pembimbing</label>
           <input type="text" class="form-control @error('nama_pembimbing') is-invalid @enderror" id="nama_pembimbing" name="nama_pembimbing" value="{{ old('nama_pembimbing') }}" required>
            @error('nama_pembimbing')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
           <label for="nama_penguji" class="form-label">Dosen Penguji</label>
           <input type="text" class="form-control @error('nama_penguji') is-invalid @enderror" id="nama_penguji" name="nama_penguji" value="{{ old('nama_penguji') }}" required>
            @error('nama_penguji')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="tanggal" class="form-label">Tanggal Seminar</label>
                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
                @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" required>
                @error('jam_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}" required>
                @error('jam_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="ruang" class="form-label">Ruang</label>
            <input type="text" class="form-control @error('ruang') is-invalid @enderror" id="ruang" name="ruang" value="{{ old('ruang') }}" required>
            @error('ruang')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('staf.seminar.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        </div>
    </form>
</div>
@endsection
