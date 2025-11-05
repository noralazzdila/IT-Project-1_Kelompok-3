@extends('layouts.app')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Status - Koordinator PKL</title>
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
        .detail-row {
            margin-bottom: 1rem;
            border-bottom: 1px dashed #ddd;
            padding-bottom: 0.5rem;
        }
        .detail-label {
            font-weight: bold;
            color: #555;
        }
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
            <a href="{{ route('koor.dashboard') }}" class="nav-link"><i class="fa fa-home me-2"></i> Beranda</a>
            <a href="{{ route('user.index') }}" class="nav-link"><i class="fa fa-users me-2"></i> Kelola User</a>
            <a href="{{ route('nilai.index') }}" class="nav-link"><i class="fa fa-graduation-cap me-2"></i> Kelola Nilai</a>
            <a href="#" class="nav-link"><i class="fa fa-building me-2"></i> Kelola Tempat PKL</a>
            <a href="#" class="nav-link"><i class="fa fa-id-card me-2"></i> Kelola Data Mahasiswa</a>
            <a href="#" class="nav-link"><i class="fa fa-chalkboard-teacher me-2"></i> Kelola Bimbingan</a>
            <a href="#" class="nav-link"><i class="fa fa-calendar me-2"></i> Kelola Seminar</a>
            <a href="#" class="nav-link"><i class="fa fa-user-check me-2"></i> Kelola Penguji</a>
            <a href="{{ route('status.index') }}" class="nav-link active"><i class="fa fa-clipboard-list me-2"></i> Kelola Status</a>
            <a href="#" class="nav-link"><i class="fa fa-file-signature me-2"></i> Proposal</a>
            <a href="#" class="nav-link"><i class="fa fa-envelope me-2"></i> Kelola Surat Pengantar</a>
            <a href="#" class="nav-link"><i class="fa fa-folder me-2"></i> Kelola Pemberkasan</a>
        </nav>
    </div>

    <div class="col-10 d-flex flex-column">
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Status</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Koordinator PKL</small>
            </div>
        </div>

        <div class="container mt-4 flex-grow-1">
            <div class="card shadow-sm p-4">
                <h6 class="fw-bold mb-4">Informasi Detail Status</h6>
                
                <div class="row">
                    <div class="col-md-6 detail-row">
                        <p class="detail-label">Nama Status:</p>
                        <p>{{ $status->nama_status }}</p>
                    </div>
                    <div class="col-md-6 detail-row">
                        <p class="detail-label">Status Saat Ini:</p>
                        <p>
                            @if($status->status == 'Menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($status->status == 'Diproses')
                                <span class="badge bg-info text-dark">Diproses</span>
                            @elseif($status->status == 'Selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 detail-row">
                        <p class="detail-label">Tanggal Status:</p>
                        {{-- Menggunakan tgl_update karena ini adalah tanggal yang di-update --}}
                        <p>{{ \Carbon\Carbon::parse($status->tgl_update)->format('d F Y') }}</p>
                    </div>
                    <div class="col-md-6 detail-row">
                        <p class="detail-label">Tanggal Dibuat (Data Awal):</p>
                        {{-- Menampilkan created_at untuk keperluan audtiting data awal --}}
                        <p>{{ \Carbon\Carbon::parse($status->created_at)->format('d F Y H:i:s') }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 detail-row">
                        <p class="detail-label">Keterangan:</p>
                        <p>{{ $status->keterangan ?? 'Tidak ada keterangan.' }}</p>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('status.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                    <a href="{{ route('status.edit', $status->id) }}" class="btn btn-primary">
                        <i class="fa fa-edit"></i> Edit Status
                    </a>
                </div>
            </div>
        </div>

        <div class="footer">
            <small>&copy; 2025 SIPRAKELRA - Sistem Informasi PKL | Politala</small>
        </div>
    </div>
</div>
</body>
</html>