<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Status - Koordinator PKL</title>
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
        /* Sidebar */
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
        /* Header */
        .header {
            background: #113F67;
            color: #fff;
            padding: 15px;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.2);
        }
        /* Footer */
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
            <a href="{{ route('tempatpkl.index') }}" class="nav-link"><i class="fa fa-building me-2"></i> Kelola Tempat PKL</a>
            <a href="{{ route('datamahasiswa.index') }}" class="nav-link"><i class="fa fa-id-card me-2"></i> Kelola Data Mahasiswa</a>
            <a href="{{ route('bimbingan.index') }}" class="nav-link"><i class="fa fa-chalkboard-teacher me-2"></i> Kelola Bimbingan</a>
            <a href="{{ route('seminar.index') }}" class="nav-link"><i class="fa fa-calendar me-2"></i> Kelola Seminar</a>
            <a href="{{ route('penguji.index') }}" class="nav-link"><i class="fa fa-user-check me-2"></i> Kelola Penguji</a>
            <a href="{{ route('status.index') }}" class="nav-link active"><i class="fa fa-clipboard-list me-2"></i> Kelola Status</a>
            <a href="{{ route('proposal.index') }}" class="nav-link"><i class="fa fa-file-signature me-2"></i> Proposal</a>
            <a href="{{ route('suratpengantar.index') }}" class="nav-link"><i class="fa fa-envelope me-2"></i> Kelola Surat Pengantar</a>
            <a href="{{ route('pemberkasan.index') }}" class="nav-link"><i class="fa fa-folder me-2"></i> Kelola Pemberkasan</a>
        </nav>
    </div>

    <div class="col-10 d-flex flex-column">
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Kelola Status</h5>
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

        <div class="container-fluid mt-4 flex-grow-1">
            <div class="card shadow-sm">
                
                {{-- CARD HEADER (diambil dari format Kelola Penguji) --}}
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Daftar Status</h4>
                    <a href="{{ route('status.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-2"></i> Tambah Status
                    </a>
                </div>

                <div class="card-body">
                    {{-- Alert di dalam card-body --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col">Nama Status</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($statuses as $i => $status)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>{{ $status->nama_status }}</td>
                                    <td>
                                        @if($status->status == 'Menunggu')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($status->status == 'Diproses')
                                            <span class="badge bg-info text-dark">Diproses</span>
                                        @elseif($status->status == 'Selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $status->keterangan ?? '-' }}</td>
                                    <td>{{ $status->tgl_update ? \Carbon\Carbon::parse($status->tgl_update)->format('d-m-Y') : '-' }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('status.destroy', $status->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus status ini?');">
                                            {{-- Show Button --}}
                                            <a href="{{ route('status.show', $status->id) }}" class="btn btn-sm btn-info text-white">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            {{-- Edit Button (Menggunakan ikon dari Penguji) --}}
                                            <a href="{{ route('status.edit', $status->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            {{-- Delete Button (Menggunakan ikon dari Penguji) --}}
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="alert alert-warning mb-0">
                                            Belum ada data status.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> {{-- Akhir card-body --}}

            </div> {{-- Akhir card shadow-sm --}}
        </div>

        <div class="footer">
            <small>&copy; 2025 SIPRAKELRA - Sistem Informasi PKL | Politala</small>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>