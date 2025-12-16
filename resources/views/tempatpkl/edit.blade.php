@extends('layouts.app')

@section('title', 'Edit Data Tempat PKL')

@section('content')
<div class="card shadow-sm p-4">
    <h5 class="fw-bold mb-3">Formulir Edit Data Tempat PKL</h5>
    
    <form action="{{ route('tempatpkl.update', $tempatpkl->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
            <select class="form-select @error('mahasiswa_id') is-invalid @enderror" id="mahasiswa_id" name="mahasiswa_id">
                <option value="">Pilih Mahasiswa</option>
                @foreach($mahasiswas as $mahasiswa)
                    <option value="{{ $mahasiswa->user_id }}" {{ old('mahasiswa_id', $selectedMahasiswaId) == $mahasiswa->user_id ? 'selected' : '' }}>
                        {{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})
                    </option>
                @endforeach
            </select>
            @error('mahasiswa_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror" id="nama_perusahaan" name="nama_perusahaan" value="{{ old('nama_perusahaan', $tempatpkl->nama_perusahaan) }}">
                @error('nama_perusahaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="jarak_lokasi" class="form-label">Jarak Lokasi (km)</label>
                <input type="number" step="0.01" class="form-control @error('jarak_lokasi') is-invalid @enderror" id="jarak_lokasi" name="jarak_lokasi" value="{{ old('jarak_lokasi', $tempatpkl->jarak_lokasi) }}">
                @error('jarak_lokasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="alamat_perusahaan" class="form-label">Alamat Perusahaan</label>
            <textarea class="form-control @error('alamat_perusahaan') is-invalid @enderror" id="alamat_perusahaan" name="alamat_perusahaan" rows="3">{{ old('alamat_perusahaan', $tempatpkl->alamat_perusahaan) }}</textarea>
            @error('alamat_perusahaan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="reputasi_perusahaan" class="form-label">Reputasi Perusahaan</label>
                <select class="form-select @error('reputasi_perusahaan') is-invalid @enderror" id="reputasi_perusahaan" name="reputasi_perusahaan">
                    <option value="">Pilih Reputasi</option>
                    <option value="Sangat Baik" {{ old('reputasi_perusahaan', $tempatpkl->reputasi_perusahaan) == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik</option>
                    <option value="Baik" {{ old('reputasi_perusahaan', $tempatpkl->reputasi_perusahaan) == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Cukup" {{ old('reputasi_perusahaan', $tempatpkl->reputasi_perusahaan) == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                    <option value="Buruk" {{ old('reputasi_perusahaan', $tempatpkl->reputasi_perusahaan) == 'Buruk' ? 'selected' : '' }}>Buruk</option>
                    <option value="Sangat Buruk" {{ old('reputasi_perusahaan', $tempatpkl->reputasi_perusahaan) == 'Sangat Buruk' ? 'selected' : '' }}>Sangat Buruk</option>
                </select>
                @error('reputasi_perusahaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="fasilitas" class="form-label">Fasilitas</label>
                <select class="form-select @error('fasilitas') is-invalid @enderror" id="fasilitas" name="fasilitas">
                    <option value="">Pilih Ketersediaan Fasilitas</option>
                    <option value="Sangat Memadai" {{ old('fasilitas', $tempatpkl->fasilitas) == 'Sangat Memadai' ? 'selected' : '' }}>Sangat Memadai</option>
                    <option value="Memadai" {{ old('fasilitas', $tempatpkl->fasilitas) == 'Memadai' ? 'selected' : '' }}>Memadai</option>
                    <option value="Cukup Memadai" {{ old('fasilitas', $tempatpkl->fasilitas) == 'Cukup Memadai' ? 'selected' : '' }}>Cukup Memadai</option>
                    <option value="Tidak Memadai" {{ old('fasilitas', $tempatpkl->fasilitas) == 'Tidak Memadai' ? 'selected' : '' }}>Tidak Memadai</option>
                    <option value="Sangat Tidak Memadai" {{ old('fasilitas', $tempatpkl->fasilitas) == 'Sangat Tidak Memadai' ? 'selected' : '' }}>Sangat Tidak Memadai</option>
                </select>
                @error('fasilitas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
         <div class="row">
            <div class="col-md-6 mb-3">
                <label for="kesesuaian_program" class="form-label">Kesesuaian Program</label>
                <select class="form-select @error('kesesuaian_program') is-invalid @enderror" id="kesesuaian_program" name="kesesuaian_program">
                    <option value="">Pilih Kesesuaian Program</option>
                    <option value="Sangat Sesuai" {{ old('kesesuaian_program', $tempatpkl->kesesuaian_program) == 'Sangat Sesuai' ? 'selected' : '' }}>Sangat Sesuai</option>
                    <option value="Sesuai" {{ old('kesesuaian_program', $tempatpkl->kesesuaian_program) == 'Sesuai' ? 'selected' : '' }}>Sesuai</option>
                    <option value="Cukup Sesuai" {{ old('kesesuaian_program', $tempatpkl->kesesuaian_program) == 'Cukup Sesuai' ? 'selected' : '' }}>Cukup Sesuai</option>
                    <option value="Tidak Sesuai" {{ old('kesesuaian_program', $tempatpkl->kesesuaian_program) == 'Tidak Sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
                    <option value="Sangat Tidak Sesuai" {{ old('kesesuaian_program', $tempatpkl->kesesuaian_program) == 'Sangat Tidak Sesuai' ? 'selected' : '' }}>Sangat Tidak Sesuai</option>
                </select>
                @error('kesesuaian_program')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
             <div class="col-md-6 mb-3">
                <label for="lingkungan_kerja" class="form-label">Lingkungan Kerja</label>
                <select class="form-select @error('lingkungan_kerja') is-invalid @enderror" id="lingkungan_kerja" name="lingkungan_kerja">
                    <option value="">Pilih Kondisi Lingkungan Kerja</option>
                    <option value="Sangat Kondusif" {{ old('lingkungan_kerja', $tempatpkl->lingkungan_kerja) == 'Sangat Kondusif' ? 'selected' : '' }}>Sangat Kondusif</option>
                    <option value="Kondusif" {{ old('lingkungan_kerja', $tempatpkl->lingkungan_kerja) == 'Kondusif' ? 'selected' : '' }}>Kondusif</option>
                    <option value="Cukup Kondusif" {{ old('lingkungan_kerja', $tempatpkl->lingkungan_kerja) == 'Cukup Kondusif' ? 'selected' : '' }}>Cukup Kondusif</option>
                    <option value="Tidak Kondusif" {{ old('lingkungan_kerja', $tempatpkl->lingkungan_kerja) == 'Tidak Kondusif' ? 'selected' : '' }}>Tidak Kondusif</option>
                    <option value="Sangat Tidak Kondusif" {{ old('lingkungan_kerja', $tempatpkl->lingkungan_kerja) == 'Sangat Tidak Kondusif' ? 'selected' : '' }}>Sangat Tidak Kondusif</option>
                </select>
                @error('lingkungan_kerja')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            <a href="{{ route('tempatpkl.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection