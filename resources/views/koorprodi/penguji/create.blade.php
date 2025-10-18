@extends('koorprodi.layouts.app')

@section('title', 'Tambah Data Penguji - Koordinator Prodi')

@section('header-title', 'Tambah Data Penguji')

@section('content')
<div class="container mt-4 flex-grow-1">
    <div class="card shadow-sm p-4">
        <h5 class="fw-bold mb-3">Formulir Data Penguji Baru</h5>
        
        <form action="{{ route('koorprodi.penguji.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_penguji" class="form-label">Nama Penguji</label>
                <input type="text" class="form-control @error('nama_penguji') is-invalid @enderror" id="nama_penguji" name="nama_penguji" value="{{ old('nama_penguji') }}" required>
                @error('nama_penguji')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip') }}" required>
                @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="no_telepon" class="form-label">No. Telepon</label>
                <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required>
                @error('no_telepon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required>
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('koorprodi.penguji.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
