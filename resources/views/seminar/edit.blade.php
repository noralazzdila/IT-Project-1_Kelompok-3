@extends('layouts.app')

@section('title', 'Edit Jadwal Seminar')

@section('content')
<div class="card shadow-sm p-4">
    <h5 class="fw-bold mb-3">Formulir Edit Jadwal Seminar</h5>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('seminar.update', $seminar->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-8 mb-3">
                <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control" name="nama_mahasiswa" value="{{ old('nama_mahasiswa', $seminar->nama_mahasiswa) }}" placeholder="Ketik nama lengkap mahasiswa">
            </div>
            <div class="col-md-4 mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" name="nim" value="{{ old('nim', $seminar->nim) }}" placeholder="Ketik NIM">
            </div>
        </div>

        <div class="mb-3">
            <label for="judul" class="form-label">Judul Seminar</label>
            <textarea class="form-control" name="judul" rows="3" placeholder="Ketik judul laporan PKL">{{ old('judul', $seminar->judul) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_pembimbing" class="form-label">Nama Pembimbing</label>
                <input type="text" class="form-control" name="nama_pembimbing" value="{{ old('nama_pembimbing', $seminar->nama_pembimbing) }}" placeholder="Ketik nama dosen pembimbing">
            </div>
            <div class="col-md-6 mb-3">
                <label for="nama_penguji" class="form-label">Nama Penguji</label>
                <select class="form-select @error('nama_penguji') is-invalid @enderror" id="nama_penguji" name="nama_penguji" required>
                    <option value="">Pilih Dosen Penguji</option>
                    @php
                       // Ambil data dosen langsung di view (sementara)
                       $dosens = \App\Models\Dosen::orderBy('nama')->get();
                    @endphp
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->nama }}" {{ old('nama_penguji', $seminar->nama_penguji) == $dosen->nama ? 'selected' : '' }}>
                            {{ $dosen->nama }} - {{ $dosen->nip }}
                        </option>
                    @endforeach
                </select>
                @error('nama_penguji')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Seminar</label>
            <input type="date" class="form-control" name="tanggal" value="{{ old('tanggal', $seminar->tanggal) }}">
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                <input type="time" class="form-control" name="jam_mulai" value="{{ old('jam_mulai', $seminar->jam_mulai) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                <input type="time" class="form-control" name="jam_selesai" value="{{ old('jam_selesai', $seminar->jam_selesai) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="ruang" class="form-label">Ruang</label>
                <input type="text" class="form-control" name="ruang" value="{{ old('ruang', $seminar->ruang) }}" placeholder="Contoh: Lab 1">
            </div>
        </div>
        
        <div class="mt-3 d-flex justify-content-end">
            <a href="{{ route('seminar.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update Jadwal</button>
        </div>
    </form>
</div>
@endsection