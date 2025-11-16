<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Surat Pengantar PKL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
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
        /* Custom breadcrumb */
        .breadcrumb {
             background-color: transparent;
             padding-left: 0;
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
                <a href="{{ route('nilai.index') }}" class="nav-link"><i class="fa fa-graduation-cap me-2"></i>Nilai</a>
                <a href="{{ route('tempatpkl.index') }}" class="nav-link"><i class="fa fa-building me-2"></i>Tempat PKL</a>
                <a href="{{ route('datamahasiswa.index') }}" class="nav-link"><i class="fa fa-id-card me-2"></i>Data Mahasiswa</a>
                <a href="{{ route('bimbingan.index') }}" class="nav-link"><i class="fa fa-chalkboard-teacher me-2"></i>Bimbingan</a>
                <a href="{{ route('seminar.index') }}" class="nav-link "><i class="fa fa-calendar me-2"></i>Seminar</a>
                <a href="{{ route('penguji.index') }}" class="nav-link"><i class="fa fa-user-check me-2"></i>Penguji</a>
                <a href="{{ route('datadosen.index') }}" class="nav-link"><i class="fa fa-users me-2"></i>Data Dosen</a>
                <a href="{{ route('proposal.index') }}" class="nav-link"><i class="fa fa-file-signature me-2"></i>Proposal</a>
                <a href="{{ route('suratpengantar.index') }}" class="nav-link active"><i class="fa fa-envelope me-2"></i>Surat Pengantar</a>
                <a href="{{ route('pemberkasan.index') }}" class="nav-link"><i class="fa fa-folder me-2"></i>Pemberkasan</a>
            </nav>
        </div>
 
        <div class="col-10 d-flex flex-column">
            <div class="header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Manajemen Surat Pengantar PKL</h5>
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

            <main class="container-fluid mt-4 flex-grow-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola Surat Pengantar</li>
                    </ol>
                </nav>

                <div class="card shadow-sm rounded-3">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Permohonan Surat Pengantar</h5>
                         <a href="{{ route('suratpengantar.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Surat Pengantar
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('suratpengantar.index') }}" method="GET" class="mb-4">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-5">
                                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau tempat PKL..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-5">
                                    <select name="status" class="form-select">
                                        <option value="">Filter Status</option>
                                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Cari</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center" style="width: 5%;">No</th>
                                        <th style="width: 25%;">Nama Mahasiswa</th>
                                        <th style="width: 30%;">Tempat PKL</th>
                                        <th class="text-center" style="width: 15%;"> Surat Pengantar</th>
                                        <th class="text-center" style="width: 10%;">Status</th>
                                        <th class="text-center" style="width: 15%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($suratPengantars as $index => $surat)
                                    <tr>
                                        <td class="text-center">{{ $suratPengantars->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $surat->nama_mahasiswa }}</strong><br>
                                            <small class="text-muted">{{ $surat->nim }} | {{ $surat->prodi }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $surat->tempat_pkl }}</strong><br>
                                            <small class="text-muted">{{ $surat->alamat_perusahaan }}</small>
                                        </td>
                                        <td class="text-center">
                                            @if ($surat->file_surat && Illuminate\Support\Facades\Storage::disk('public')->exists($surat->file_surat))
                                                <a href="{{ Illuminate\Support\Facades\Storage::disk('public')->url($surat->file_surat) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-file-pdf me-1"></i> Lihat File
                                                </a>
                                            @else
                                                <span class="badge bg-secondary">Belum Ada</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $badgeClass = match($surat->status) {
                                                    'Menunggu' => 'bg-warning text-dark',
                                                    'Diproses' => 'bg-primary',
                                                    'Selesai' => 'bg-success',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $surat->status }}</span>
                                        </td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?');" action="{{ route('suratpengantar.destroy', $surat->id) }}" method="POST">
                                                <a href="{{ route('suratpengantar.show', $surat->id) }}" class="btn btn-info btn-sm text-white" title="Lihat"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('suratpengantar.edit', $surat->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div class="alert alert-warning mb-0">
                                                Data permohonan surat pengantar tidak ditemukan.
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-3">
                            {{ $suratPengantars->links() }}
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

