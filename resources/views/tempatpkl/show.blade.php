<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tempat PKL - Koordinator PKL</title>
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
        
        /* Custom styles for detail list */
        .detail-list .row {
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid #dee2e6;
        }
        .detail-list .row:last-child {
            border-bottom: none;
        }
        .detail-list dt {
            font-weight: 600;
            color: #495057;
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
            <a href="{{ route('user.index') }}" class="nav-link"><i class="fa fa-users me-2"></i>User</a>
            <a href="{{ route('nilai.index') }}" class="nav-link "><i class="fa fa-graduation-cap me-2"></i>Nilai</a>
            <a href="{{ route('tempatpkl.index') }}" class="nav-link active"><i class="fa fa-building me-2"></i>Tempat PKL</a>
            <a href="{{ route('datamahasiswa.index') }}" class="nav-link"><i class="fa fa-id-card me-2"></i>Data Mahasiswa</a>
            <a href="{{ route('bimbingan.index') }}" class="nav-link"><i class="fa fa-chalkboard-teacher me-2"></i>Bimbingan</a>
            <a href="{{ route('seminar.index') }}" class="nav-link"><i class="fa fa-calendar me-2"></i>Seminar</a>
            <a href="{{ route('penguji.index') }}" class="nav-link"><i class="fa fa-user-check me-2"></i>Penguji</a>
            <a href="{{ route('datadosen.index') }}" class="nav-link"><i class="fa fa-users me-2"></i>Data Dosen</a>
            <a href="{{ route('proposal.index') }}" class="nav-link"><i class="fa fa-file-signature me-2"></i> Proposal</a>
            <a href="{{ route('suratpengantar.index') }}" class="nav-link"><i class="fa-solid fa-envelope me-2"></i>Surat Pengantar</a>
            <a href="{{ route('pemberkasan.index') }}" class="nav-link"><i class="fa-solid fa-folder me-2"></i>Pemberkasan</a>
        </nav>
    </div>

    <div class="col-10 d-flex flex-column">
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Data Tempat PKL</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Koordinator PKL</small>
            </div>
        </div>

        <div class="container mt-4 flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Detail Perusahaan: {{ $tempatpkl->nama_perusahaan }}</h6>
                <a href="{{ route('tempatpkl.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4 detail-list">
                    <dl>
                        <div class="row">
                            <dt class="col-sm-4">Nama Perusahaan</dt>
                            <dd class="col-sm-8">{{ $tempatpkl->nama_perusahaan }}</dd>
                        </div>
                        <div class="row">
                            <dt class="col-sm-4">Alamat Perusahaan</dt>
                            <dd class="col-sm-8">{{ $tempatpkl->alamat_perusahaan }}</dd>
                        </div>
                        <div class="row">
                            <dt class="col-sm-4">Jarak Lokasi</dt>
                            <dd class="col-sm-8">{{ $tempatpkl->jarak_lokasi ? $tempatpkl->jarak_lokasi . ' km' : '-' }}</dd>
                        </div>
                        <div class="row">
                            <dt class="col-sm-4">Reputasi Perusahaan</dt>
                            <dd class="col-sm-8">{{ $tempatpkl->reputasi_perusahaan }}</dd>
                        </div>
                        <div class="row">
                            <dt class="col-sm-4">Fasilitas</dt>
                            <dd class="col-sm-8">{{ $tempatpkl->fasilitas }}</dd>
                        </div>
                        <div class="row">
                            <dt class="col-sm-4">Kesesuaian Program Magang</dt>
                            <dd class="col-sm-8">{{ $tempatpkl->kesesuaian_program }}</dd>
                        </div>
                        <div class="row">
                            <dt class="col-sm-4">Lingkungan Kerja</dt>
                            <dd class="col-sm-8">{{ $tempatpkl->lingkungan_kerja }}</dd>
                        </div>
                    </dl>
                </div>
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