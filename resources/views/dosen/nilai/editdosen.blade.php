@extends('layouts.app')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nilai - Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f5f7fa;
        }
        .wrapper { flex: 1; display: flex; }
        .sidebar {
            background: #ffffff;
            min-height: 100vh;
            padding-top: 20px;
            box-shadow: 2px 0 6px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: #333; font-weight: 500; margin-bottom: 5px; transition: all 0.3s ease;
        }
        .sidebar .nav-link.active {
            background: #113F67; color: #fff !important; border-radius: 8px;
        }
        .sidebar .nav-link:hover { background: #e9ecef; border-radius: 8px; }
        .header { background: #113F67; color: #fff; padding: 15px; box-shadow: 0px 2px 6px rgba(0,0,0,0.2); }
        .footer { background: #113F67; color: #fff; padding: 12px; text-align: center; margin-top: auto; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="col-2 sidebar">
        <div class="text-center mb-4">
            <img src="{{ asset('images/Logo_Politala.png') }}" width="80" alt="Logo">
            <h6 class="fw-bold mt-2">SIPRAKELRA</h6>
            <small class="text-muted">Sistem Informasi PKL</small>
        </div>
        <nav class="nav flex-column px-2">
            <a href="{{ route('dosen.dashboard') }}" class="nav-link {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}"><i class="fa fa-home me-2"></i> Beranda</a>
                <a href="{{ route('dosen.user.index') }}" class="nav-link {{ request()->routeIs('dosen.user.*') ? 'active' : '' }}"><i class="fa fa-users me-2"></i> Kelola User</a>
                <a href="{{ route('dosen.nilai.indexdosen') }}" class="nav-link {{ request()->routeIs('dosen.nilai.*') ? 'active' : '' }}"><i class="fa fa-graduation-cap me-2"></i> Kelola Nilai</a>
                <a href="{{ route('dosen.datamahasiswa.index') }}" class="nav-link {{ request()->routeIs('dosen.datamahasiswa.*') ? 'active' : '' }}"><i class="fa fa-id-card me-2"></i> Kelola Data Mahasiswa</a>
                <a href="{{ route('dosen.datadosen.indexdatadosen') }}" class="nav-link {{ request()->routeIs('datadosen.*') ? 'active' : '' }}"><i class="fa fa-users me-2"></i> Kelola Data Dosen</a>
                <a href="{{ route('dosen.bimbingan.indexdosen') }}" class="nav-link {{ request()->routeIs('dosen.bimbingan.*') ? 'active' : '' }}"><i class="fa fa-chalkboard-teacher me-2"></i> Kelola Bimbingan</a>
                <a href="{{ route('dosen.seminar.indexdosen') }}" class="nav-link {{ request()->routeIs('dosen.seminar.*') ? 'active' : '' }}"><i class="fa fa-calendar me-2"></i> Kelola Seminar</a>
                <a href="{{ route('dosen.penguji.indexdosen') }}" class="nav-link {{ request()->routeIs('dosen.penguji.*') ? 'active' : '' }}"><i class="fa fa-user-check me-2"></i> Kelola Penguji</a>
        </nav>
    </div>

    <div class="col-10 d-flex flex-column">
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Nilai Mahasiswa</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Dosen</small>
            </div>
        </div>

        <div class="container mt-4 flex-grow-1">
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
                      <a href="{{ route('dosen.nilai.indexdosen') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
                      <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
                  </div>
                </form>
            </div>
        </div>

        <div class="footer">
            <small>&copy; 2025 SIPRAKELRA - Sistem Informasi PKL | Politala</small>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>