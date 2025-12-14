@extends('layouts.app')

@section('title', 'Tambah Data Dosen')

@section('content')
<div class="card shadow-sm p-4">
    <h5 class="fw-bold mb-3">Formulir Data Dosen Baru</h5>
    
    <form action="{{ route('datadosen.store') }}" method="POST">
        @csrf
         <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
         <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip') }}" required>
                @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" required>
                @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('datadosen.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        </div>
    </form>
</div>
@endsection