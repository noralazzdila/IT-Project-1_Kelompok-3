@extends('layouts.app')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User - Dosen</title>
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
            color: #333;
            font-weight: 500;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link.active {
            background: #113F67;
            color: #fff !important;
            border-radius: 8px;
        }
        .sidebar .nav-link:hover {
            background: #e9ecef;
            border-radius: 8px;
        }
        .header {
            background: #113F67;
            color: #fff;
            padding: 15px;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.2);
        }
        .footer {
            background: #113F67;
            color: #fff;
            padding: 12px;
            text-align: center;
            margin-top: auto;
        }
        .info-box {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 25px;
        }
        .info-label {
            font-weight: 600;
            color: #555;
        }
        .info-value {
            color: #222;
            font-size: 16px;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Sidebar -->
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

    <!-- Main Content -->
    <div class="col-10 d-flex flex-column">
        <!-- Header -->
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail User</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Dosen</small>
            </div>
        </div>

        <!-- Content -->
        <div class="container mt-4 flex-grow-1">
            <div class="card shadow-sm p-4">
                <h6 class="fw-bold mb-3"><i class="fa fa-user-circle me-2"></i> Informasi Lengkap User</h6>

                <div class="info-box">
                    <div class="row mb-3">
                        <div class="col-md-4 info-label">Nama Lengkap:</div>
                        <div class="col-md-8 info-value">{{ $user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 info-label">Email:</div>
                        <div class="col-md-8 info-value">{{ $user->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 info-label">Role / Hak Akses:</div>
                        <div class="col-md-8 info-value text-capitalize">{{ $user->role }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 info-label">NIP / NIM:</div>
                        <div class="col-md-8 info-value">{{ $user->identifier ?? '-' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 info-label">Status Akun:</div>
                        <div class="col-md-8">
                            @if($user->status == 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 info-label">Tanggal Dibuat:</div>
                        <div class="col-md-8 info-value">{{ $user->created_at->format('d M Y, H:i') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 info-label">Terakhir Diperbarui:</div>
                        <div class="col-md-8 info-value">{{ $user->updated_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('dosen.user.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <small>&copy; 2025 SIPRAKELRA - Sistem Informasi PKL | Politala</small>
        </div>
    </div>
</div>
</body>
</html>
