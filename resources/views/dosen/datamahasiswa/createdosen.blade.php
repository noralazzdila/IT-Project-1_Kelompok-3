<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
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
                <h5 class="mb-0">Tambah Data Mahasiswa</h5>
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
                        <li class="breadcrumb-item active" aria-current="page">Tambah Mahasiswa</li>
                    </ol>
                </nav>

                <div class="card rounded-3 shadow-sm border-0">
                    <div class="card-header text-white" style="background-color: #113F67;">
                        <h5 class="mb-0"><i class="fa-solid fa-user-plus me-2"></i>Form Tambah Mahasiswa</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dosen.datamahasiswa.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}" required>
                                    @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div class="mt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="laki">Laki-laki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perempuan">Perempuan</label>
                                        </div>
                                    </div>
                                    @error('jenis_kelamin')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="prodi" class="form-label">Program Studi</label>
                                    <input type="text" class="form-control @error('prodi') is-invalid @enderror" id="prodi" name="prodi" value="{{ old('prodi') }}" required>
                                    @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" value="{{ old('kelas') }}" required>
                                    @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tahun_angkatan" class="form-label">Tahun Angkatan</label>
                                    <input type="number" class="form-control @error('tahun_angkatan') is-invalid @enderror" id="tahun_angkatan" name="tahun_angkatan" value="{{ old('tahun_angkatan') }}" placeholder="YYYY" required>
                                    @error('tahun_angkatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="dosen_pembimbing" class="form-label">Dosen Pembimbing</label>
                                <input type="text" class="form-control @error('dosen_pembimbing') is-invalid @enderror" id="dosen_pembimbing" name="dosen_pembimbing" value="{{ old('dosen_pembimbing') }}" required>
                                @error('dosen_pembimbing')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="tempat_pkl" class="form-label">Tempat PKL</label>
                                <input type="text" class="form-control @error('tempat_pkl') is-invalid @enderror" id="tempat_pkl" name="tempat_pkl" value="{{ old('tempat_pkl') }}" required>
                                @error('tempat_pkl')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="status_pkl" class="form-label">Status PKL</label>
                                    <select class="form-select @error('status_pkl') is-invalid @enderror" id="status_pkl" name="status_pkl" required>
                                        <option value="Belum Mulai" {{ old('status_pkl') == 'Belum Mulai' ? 'selected' : '' }}>Belum Mulai</option>
                                        <option value="Sedang PKL" {{ old('status_pkl') == 'Sedang PKL' ? 'selected' : '' }}>Sedang PKL</option>
                                        <option value="Selesai" {{ old('status_pkl') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                    @error('status_pkl')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="no_hp" class="form-label">No. HP</label>
                                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                                    @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('dosen.datamahasiswa.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-arrow-left me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-save me-2"></i>Simpan
                                </button>
                            </div>
                        </form>
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
