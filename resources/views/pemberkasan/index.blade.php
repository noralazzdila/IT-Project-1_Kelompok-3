<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pemberkasan - Koordinator PKL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
    </style>
</head>

<body>
<div class="wrapper">

    {{-- SIDEBAR --}}
    <div class="col-2 sidebar">
        <div class="text-center mb-4">
            <img src="{{ asset('images/Logo_Politala.png') }}" width="80" alt="Logo">
            <h6 class="fw-bold mt-2">SIPRAKELRA</h6>
            <small class="text-muted">Sistem Informasi PKL</small>
        </div>

        <nav class="nav flex-column px-2">
            <a href="{{ route('koor.dashboard') }}" class="nav-link"><i class="fa fa-home me-2"></i> Beranda</a>
            <a href="{{ route('user.index') }}" class="nav-link"><i class="fa fa-users me-2"></i>User</a>
            <a href="{{ route('nilai.index') }}" class="nav-link"><i class="fa fa-graduation-cap me-2"></i>Nilai</a>
            <a href="{{ route('tempatpkl.index') }}" class="nav-link"><i class="fa fa-building me-2"></i>Tempat PKL</a>
            <a href="{{ route('datamahasiswa.index') }}" class="nav-link"><i class="fa fa-id-card me-2"></i>Data Mahasiswa</a>
            <a href="{{ route('bimbingan.index') }}" class="nav-link"><i class="fa fa-chalkboard-teacher me-2"></i>Bimbingan</a>
            <a href="{{ route('seminar.index') }}" class="nav-link"><i class="fa fa-calendar me-2"></i>Seminar</a>
            <a href="{{ route('penguji.index') }}" class="nav-link"><i class="fa fa-user-check me-2"></i>Penguji</a>
            <a href="{{ route('datadosen.index') }}" class="nav-link"><i class="fa fa-users me-2"></i>Data Dosen</a>
            <a href="{{ route('proposal.index') }}" class="nav-link"><i class="fa fa-file-signature me-2"></i> Proposal</a>
            <a href="{{ route('suratpengantar.index') }}" class="nav-link"><i class="fa fa-envelope me-2"></i>Surat Pengantar</a>
            <a href="{{ route('pemberkasan.index') }}" class="nav-link active"><i class="fa fa-folder me-2"></i>Pemberkasan</a>
        </nav>
    </div>

    {{-- KONTEN UTAMA --}}
    <div class="col-10 d-flex flex-column">
        
        {{-- HEADER --}}
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Manajemen Pemberkasan PKL</h5>
            <div class="dropdown text-end">
                <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                    <small>Koordinator PKL</small>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit me-2"></i>Edit Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>

        {{-- TABEL DATA --}}
        <div class="container-fluid mt-4 flex-grow-1">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Daftar Status Pemberkasan Mahasiswa</h4>
                    <a href="{{ route('pemberkasan.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-upload me-2"></i> Upload Berkas
                    </a>
                </div>

                <div class="card-body">
                    {{-- Alert sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Tabel --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Mahasiswa</th>
                                    <th>Form Bimbingan</th>
                                    <th>Sertifikat</th>
                                    <th>Laporan Final</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pemberkasan as $berkas)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $berkas->mahasiswa->nama ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">{{ $berkas->mahasiswa->nim ?? '-' }}</small>
                                    </td>

                                    {{-- Form Bimbingan --}}
                                    <td class="text-center">
                                        @if($berkas->form_bimbingan_path)
                                            <a href="{{ asset('storage/' . $berkas->form_bimbingan_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="fa-solid fa-eye me-1"></i> Lihat File
                                            </a>
                                        @else
                                            <span class="badge bg-danger">X Belum</span>
                                        @endif
                                    </td>

                                    {{-- Sertifikat --}}
                                    <td class="text-center">
                                        @if($berkas->sertifikat_path)
                                            <a href="{{ asset('storage/' . $berkas->sertifikat_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="fa-solid fa-eye me-1"></i> Lihat File
                                            </a>
                                        @else
                                            <span class="badge bg-danger">X Belum</span>
                                        @endif
                                    </td>

                                    {{-- Laporan Final --}}
                                    <td class="text-center">
                                        @if($berkas->laporan_final_path)
                                            <a href="{{ asset('storage/' . $berkas->laporan_final_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="fa-solid fa-eye me-1"></i> Lihat File
                                            </a>
                                        @else
                                            <span class="badge bg-danger">X Belum</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="text-center">
                                        <span class="badge bg-{{ $berkas->is_lengkap ? 'primary' : 'warning text-dark' }}">
                                            {{ $berkas->is_lengkap ? 'Lengkap' : 'Belum Lengkap' }}
                                        </span>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="text-center">
                                        <a href="{{ route('pemberkasan.show', $berkas->id) }}" class="btn btn-sm btn-info text-white" title="Detail">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </a>
                                        <a href="{{ route('pemberkasan.edit', $berkas->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('pemberkasan.destroy', $berkas->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data pemberkasan ini? Seluruh file terkait akan dihapus permanen.');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="alert alert-secondary mb-0">
                                            Belum ada data pemberkasan yang diunggah.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $pemberkasan->links() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="footer">
            <small>&copy; 2025 SIPRAKELRA - Sistem Informasi PKL | Politala</small>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
