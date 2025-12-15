<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberkasan | SIPRAKERLA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #e9f2ff;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main { flex: 1; }

        .navbar {
            background-color: #004080;
            box-shadow: 0 3px 12px rgba(0,0,0,.15);
        }
        .navbar-brand, .nav-link { color: #fff !important; }

        .card {
            background: rgba(243,244,245,0.35);
            border-radius: 18px;
            border: 1px solid rgba(0,64,128,0.3);
            animation: fadeInUp .7s ease forwards;
            transform: translateY(15px);
            opacity: 0;
        }

        .table thead { background-color: #004080 !important; color: #fff; }
        .table tbody tr:hover { background: rgba(0,64,128,0.08); }

        .btn-secondary {
            background-color: #004080;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            transition: .3s;
        }
        .btn-secondary:hover {
            background-color: #003366;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(0,0,0,0.25);
        }

        .btn-primary { border-radius: 10px; }

        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .footer {
            background: #004080;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard.mahasiswa') }}">
                <img src="{{ asset('images/Logo_Politala.png') }}" width="40" class="me-2">
                SIPRAKERLA | Mahasiswa
            </a>

            <div class="dropdown ms-auto">
                <a href="#" class="text-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="fw-semibold">{{ Auth::user()->name }}</span><br>
                    <small>Mahasiswa</small>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <a class="dropdown-item" href="{{ route('mahasiswa.profil') }}">
                            <i class="fas fa-user-edit me-2"></i>Edit Profil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main class="container mt-4 mb-4">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.mahasiswa') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pemberkasan</li>
            </ol>
        </nav>

        <div class="card shadow-sm">
            <div class="card-body">

                <h5 class="fw-bold text-primary mb-3">
                    <i class="fa-solid fa-folder me-2"></i>Pemberkasan PKL
                </h5>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- TOMBOL UPLOAD -->
                <div class="text-end mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadBerkasBaru">
                        <i class="fa-solid fa-upload me-1"></i> Upload Berkas
                    </button>
                </div>

                <!-- TABEL -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Mahasiswa</th>
                                <th>Status</th>
                                <th>File</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($pemberkasans as $pemberkasan)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $pemberkasan->mahasiswa?->nama ?? Auth::user()->name }}</td>
                                <td>
                                    @if ($pemberkasan->is_lengkap)
                                        <span class="badge bg-success">Lengkap</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum Lengkap</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($pemberkasan->form_bimbingan_path)
                                    <a href="{{ route('pemberkasan.view', ['file' => basename($pemberkasan->form_bimbingan_path)]) }}" target="_blank" class="btn btn-outline-primary btn-sm me-1">
                                        <i class="fa-solid fa-file-pdf me-1"></i> Form Bimbingan
                                    </a>
                                    @endif
                                    
                                    @if ($pemberkasan->sertifikat_path)
                                    <a href="{{ route('pemberkasan.view', ['file' => basename($pemberkasan->sertifikat_path)]) }}" target="_blank" class="btn btn-outline-primary btn-sm me-1">
                                        <i class="fa-solid fa-file-pdf me-1"></i> Sertifikat
                                    </a>
                                    @endif
                                    
                                    @if ($pemberkasan->laporan_final_path)
                                    <a href="{{ route('pemberkasan.view', ['file' => basename($pemberkasan->laporan_final_path)]) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fa-solid fa-file-pdf me-1"></i> Laporan Final
                                    </a>
                                    @endif

                                </td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $pemberkasan->id }}">
                                        <i class="fa-solid fa-upload me-1"></i> Upload
                                    </button>
                                </td>
                            </tr>

                            <!-- MODAL PER ITEM -->
                            <div class="modal fade" id="uploadModal{{ $pemberkasan->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Upload Berkas untuk {{ $pemberkasan->mahasiswa?->nama ?? Auth::user()->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('mahasiswa.pemberkasan.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <label class="form-label fw-semibold">Tipe Dokumen</label>
                                                <select name="type" class="form-control" required>
                                                    <option value="form_bimbingan">Form Bimbingan</option>
                                                    <option value="sertifikat">Sertifikat PKL</option>
                                                    <option value="laporan_final">Laporan Final</option>
                                                </select>

                                                <label class="form-label fw-semibold mt-3">File (PDF)</label>
                                                <input type="file" name="file" class="form-control" accept="application/pdf" required>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Upload</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-danger fw-bold py-3">
                                    Belum ada data pemberkasan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <a href="{{ route('dashboard.mahasiswa') }}" class="btn btn-secondary mt-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                </a>

            </div>
        </div>

        <!-- MODAL UPLOAD BARU -->
        <div class="modal fade" id="uploadBerkasBaru" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Upload Berkas Pemberkasan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('mahasiswa.pemberkasan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <label class="form-label fw-semibold">Tipe Dokumen</label>
                            <select name="type" class="form-control" required>
                                <option value="form_bimbingan">Form Bimbingan</option>
                                <option value="sertifikat">Sertifikat PKL</option>
                                <option value="laporan_final">Laporan Final</option>
                            </select>

                            <label class="form-label fw-semibold mt-3">File (PDF)</label>
                            <input type="file" name="file" class="form-control" accept="application/pdf" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <div class="footer">
        <small>&copy; 2025 SIPRAKERLA - Politeknik Negeri Tanah Laut</small>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
