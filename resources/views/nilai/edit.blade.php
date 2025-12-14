@extends('layouts.app')

@section('title', 'Edit Nilai Mahasiswa')

@section('content')
<div class="card shadow-sm p-4">

    @if ($errors->any())
      <div class="alert alert-danger">
          <strong>Terjadi kesalahan!</strong>
          <ul class="mb-0 mt-2">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form action="{{ route('nilai.update', $nilai->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="row">
          <h6 class="fw-semibold mt-2 mb-2 text-primary">🧑‍🎓 Data Mahasiswa</h6>
          <div class="col-md-6 mb-3">
              <label class="form-label">NIM <span class="text-danger">*</span></label>
              <input type="text" name="nim" class="form-control" value="{{ old('nim', $nilai->mahasiswa->nim ?? '') }}" required>
          </div>
          <div class="col-md-6 mb-3">
              <label class="form-label">Nama <span class="text-danger">*</span></label>
              <input type="text" name="nama" class="form-control" value="{{ old('nama', $nilai->mahasiswa->nama ?? '') }}" required>
          </div>
          <div class="col-md-6 mb-3">
              <label class="form-label">Jurusan</label>
              <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan', $nilai->mahasiswa->jurusan ?? '') }}">
          </div>
          <div class="col-md-6 mb-3">
              <label class="form-label">Angkatan</label>
              <input type="text" name="angkatan" class="form-control" value="{{ old('angkatan', $nilai->mahasiswa->angkatan ?? '') }}">
          </div>

          <h6 class="fw-semibold mt-4 mb-2 text-success">📘 Data Nilai</h6>
          <div class="col-md-4 mb-3">
              <label class="form-label">IPK</label>
              <input type="number" step="0.01" name="ipk" class="form-control" value="{{ old('ipk', $nilai->ipk ?? 0) }}">
          </div>
          <div class="col-md-4 mb-3">
              <label class="form-label">Total SKS</label>
              <input type="number" name="total_sks" class="form-control" value="{{ old('total_sks', $nilai->total_sks ?? 0) }}">
          </div>
          <div class="col-md-4 mb-3">
              <label class="form-label">Total SKS Nilai D</label>
              <input type="number" name="sks_d" class="form-control" value="{{ old('sks_d', $nilai->sks_d ?? 0) }}">
          </div>

          @foreach(['A','B+','B','C+','C','D','E'] as $grade)
              <div class="col-md-2 mb-3">
                  <label class="form-label">Jumlah {{ $grade }}</label>
                  <input type="number" name="count_{{ strtolower(str_replace('+','_plus',$grade)) }}" class="form-control" value="{{ old('count_'.strtolower(str_replace('+','_plus',$grade)), $nilai->{'count_'.strtolower(str_replace('+','_plus',$grade))} ?? 0) }}">
              </div>
          @endforeach
      </div>

      <div class="mt-3 d-flex justify-content-between">
          <a href="{{ route('nilai.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
      </div>
    </form>
</div>
@endsection