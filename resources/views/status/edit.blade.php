@extends('layouts.app')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Status - Koordinator PKL</title>
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
    <!-- Sidebar -->
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

    <!-- Main Content -->
    <div class="col-10 d-flex flex-column">
        <!-- Header -->
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Status</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Koordinator PKL</small>
            </div>
        </div>

        <!-- Content -->
        <div class="container mt-4 flex-grow-1">
            <div class="card shadow-sm p-4">
                <h6 class="fw-bold mb-3">Form Edit Status</h6>
                <form action="{{ route('status.update', $status->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_status" class="form-label">Nama Status</label>
                        <input type="text" class="form-control" id="nama_status" name="nama_status"
                               value="{{ old('nama_status', $status->nama_status) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Menunggu" {{ old('status', $status->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Diproses" {{ old('status', $status->status) == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ old('status', $status->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $status->keterangan) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="tgl_update" class="form-label">Tanggal Status</label>
                        <input 
                        type="date" 
                        name="tgl_update" 
                        id="tgl_update" 
                        class="form-control" required
                        value="{{ old('tgl_update', \Carbon\Carbon::parse($status->tgl_update)->format('Y-m-d')) }}">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('status.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Perbarui Status
                        </button>
                    </div>
                </form>
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
