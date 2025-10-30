<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Bimbingan - Koordinator PKL</title>
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
        .detail-label { font-weight: 600; color: #6c757d; }
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
            <h5 class="mb-0">Detail Data Bimbingan</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Dosen</small>
            </div>
        </div>

        <div class="container mt-4 flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Detail Bimbingan: {{ $bimbingan->mahasiswa_nama }}</h6>
                <a href="{{ route('dosen.bimbingan.indexdosen') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card shadow-sm p-4">
                <dl class="row">
                    <dt class="col-sm-3 detail-label">Nama Mahasiswa</dt>
                    <dd class="col-sm-9">{{ $bimbingan->mahasiswa_nama }}</dd>

                    <dt class="col-sm-3 detail-label">NIM</dt>
                    <dd class="col-sm-9">{{ $bimbingan->nim }}</dd>

                    <dt class="col-sm-3 detail-label">Dosen Pembimbing</dt>
                    <dd class="col-sm-9">{{ $bimbingan->dosen_pembimbing }}</dd>

                    <dt class="col-sm-3 detail-label">Tanggal</dt>
                    <dd class="col-sm-9">{{ $bimbingan->tanggal_bimbingan->format('d F Y') }}</dd>

                    <dt class="col-sm-3 detail-label">Topik</dt>
                    <dd class="col-sm-9">{{ $bimbingan->topik_bimbingan }}</dd>

                    <dt class="col-sm-3 detail-label">Status</dt>
                    <dd class="col-sm-9">
                        @if($bimbingan->status == 'Disetujui')
                            <span class="badge bg-success">{{ $bimbingan->status }}</span>
                        @elseif($bimbingan->status == 'Revisi')
                            <span class="badge bg-warning text-dark">{{ $bimbingan->status }}</span>
                        @else
                            <span class="badge bg-secondary">{{ $bimbingan->status }}</span>
                        @endif
                    </dd>

                    <dt class="col-sm-3 detail-label mt-3">Catatan</dt>
                    <dd class="col-sm-9 mt-3"><p style="text-align: justify;">{{ $bimbingan->catatan }}</p></dd>
                </dl>
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