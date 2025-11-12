@extends('layouts.app')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - Koordinator PKL</title>
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
            <a href="{{ route('user.index') }}" class="nav-link active"><i class="fa fa-users me-2"></i>User</a>
            <a href="{{ route('nilai.index') }}" class="nav-link"><i class="fa fa-graduation-cap me-2"></i>Nilai</a>
            <a href="{{ route('tempatpkl.index') }}" class="nav-link "><i class="fa fa-building me-2"></i>Tempat PKL</a>
            <a href="{{ route('datamahasiswa.index') }}" class="nav-link"><i class="fa fa-id-card me-2"></i>Data Mahasiswa</a>
            <a href="{{ route('bimbingan.index') }}" class="nav-link"><i class="fa fa-chalkboard-teacher me-2"></i>Bimbingan</a>
            <a href="{{ route('seminar.index') }}" class="nav-link "><i class="fa fa-calendar me-2"></i>Seminar</a>
            <a href="{{ route('penguji.index') }}" class="nav-link"><i class="fa fa-user-check me-2"></i>Penguji</a>
            <a href="{{ route('datadosen.index') }}" class="nav-link"><i class="fa fa-users me-2"></i>Data Dosen</a>
            <a href="{{ route('proposal.index') }}" class="nav-link"><i class="fa fa-file-signature me-2"></i>Proposal</a>
            <a href="{{ route('suratpengantar.index') }}" class="nav-link"><i class="fa-solid fa-envelope me-2"></i>Surat Pengantar</a>
            <a href="{{ route('pemberkasan.index') }}" class="nav-link"><i class="fa-solid fa-folder me-2"></i>Pemberkasan</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="col-10 d-flex flex-column">
        <!-- Header -->
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tambah User Baru</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Koordinator PKL</small>
            </div>
        </div>

        <!-- Content -->
        <div class="container mt-4 flex-grow-1">
            <div class="card shadow-sm p-4">
                <h6 class="fw-bold mb-3"><i class="fa fa-user-plus me-2"></i> Form Tambah User</h6>

                <form action="{{ route('user.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label fw-semibold">Nama Lengkap</label>
        <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Role / Hak Akses</label>
        <select name="role" class="form-select" required>
            <option value="" selected disabled>Pilih Role</option>
            <option value="koordinator">Koordinator PKL</option>
            <option value="dosen">Dosen</option>
            <option value="staff">Staff</option>
            <option value="kaprodi">Kepala Program Studi</option>
            <option value="mahasiswa">Mahasiswa</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">NIP / NIM</label>
        <input type="text" name="identifier" class="form-control" placeholder="Opsional (jika ada)">
    </div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Status</label>
        <select name="status" class="form-select" required>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
        </select>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('user.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save me-1"></i> Simpan
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
