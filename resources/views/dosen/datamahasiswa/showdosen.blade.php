<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f5f7fa;
        }
        .wrapper {
            flex: 1;
            display: flex;
        }
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
        .breadcrumb {
            background-color: transparent;
            padding-left: 0;
        }
        .card {
            border: 0;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.1);
        }
        .detail-label {
            font-weight: 600;
            color: #6c757d;
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

        <!-- Konten utama -->
        <div class="col-10 d-flex flex-column">
            <!-- Header -->
            <div class="header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Data Mahasiswa</h5>
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span><br>
                        <small>Dosen</small>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit me-2"></i>Edit Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>

            <main class="container-fluid mt-4 flex-grow-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dosen.datamahasiswa.index') }}">Kelola Mahasiswa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Mahasiswa</li>
                    </ol>
                </nav>

                <div class="card rounded-3 shadow-sm border-0">
                    <div class="card-header text-white" style="background-color: #113F67;">
                        <h5 class="mb-0"><i class="fa-solid fa-user-graduate me-2"></i>Detail Data Mahasiswa</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-4 border-bottom pb-2">Data Pribadi</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-5 detail-label">Nama Lengkap</dt>
                                    <dd class="col-sm-7">{{ $datamahasiswa->nama }}</dd>

                                    <dt class="col-sm-5 detail-label">NIM</dt>
                                    <dd class="col-sm-7">{{ $datamahasiswa->nim }}</dd>

                                    <dt class="col-sm-5 detail-label">Jenis Kelamin</dt>
                                    <dd class="col-sm-7">{{ $datamahasiswa->jenis_kelamin }}</dd>

                                    <dt class="col-sm-5 detail-label">Tanggal Lahir</dt>
                                    <dd class="col-sm-7">{{ $datamahasiswa->tanggal_lahir }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-5 detail-label">Email</dt>
                                    <dd class="col-sm-7">{{ $datamahasiswa->email }}</dd>
                                    
                                    <dt class="col-sm-5 detail-label">No. HP</dt>
                                    <dd class="col-sm-7">{{ $datamahasiswa->no_hp }}</dd>
                                </dl>
                            </div>
                        </div>

                        <h6 class="mt-4 mb-4 border-bottom pb-2">Data Akademik & PKL</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-5 detail-label">Program Studi</dt>
                                    <dd class="col-sm-7">{{ $datamahasiswa->prodi }}</dd>

                                    <dt class="col-sm-5 detail-label">Kelas</dt>
                                    <dd class="col-sm-7">{{ $datamahasiswa->kelas }}</dd>

                                    <dt class="col-sm-5 detail-label">Tahun Angkatan</dt>
                                    <dd class="col-sm-7">{{ $datamahasiswa->tahun_angkatan }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-5 detail-label">Dosen Pembimbing</dt>
                                    <dd class="col-sm-7">{{ $datamahasiswa->dosen_pembimbing }}</dd>
                                    
                                    <dt class="col-sm-5 detail-label">Tempat PKL</dt>
                                    <dd class="col-sm-7">{{ $datamahasiswa->tempat_pkl }}</dd>

                                    <dt class="col-sm-5 detail-label">Status PKL</dt>
                                    <dd class="col-sm-7">
                                        <span class="badge 
                                            @if($datamahasiswa->status_pkl == 'Belum Mulai') bg-secondary 
                                            @elseif($datamahasiswa->status_pkl == 'Sedang PKL') bg-warning text-dark
                                            @elseif($datamahasiswa->status_pkl == 'Selesai') bg-success
                                            @endif fs-6">
                                            {{ $datamahasiswa->status_pkl }}
                                        </span>
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <a href="{{ route('dosen.datamahasiswa.index') }}" class="btn btn-secondary">
                                <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </main>

            <div class="footer">
                <small>&copy; 2025 SIPRAKELRA - Sistem Informasi PKL | Politala</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
