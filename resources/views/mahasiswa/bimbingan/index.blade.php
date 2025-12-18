<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Bimbingan | Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #e9f2ff;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Penting untuk sticky footer */
        }

        main {
            flex: 1; /* Dorong footer ke bawah */
        }

        .navbar {
            background-color: #004080;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .15);
        }
        .navbar-brand, .nav-link {
            color: #ffffff !important;
        }

        .frosted-card {
            background: rgba(243, 244, 245, 0.35);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            border: 1px solid rgba(0,64,128,0.3);
            animation: fadeInUp .7s ease forwards;
            transform: translateY(15px);
            opacity: 0;
        }

        .table th {
            background-color: #004080;
            color: #fff;
            border: none;
        }
        .table tbody tr:hover {
            background: rgba(0,64,128,0.08);
        }

        .frosted-btn {
            background-color: #004080;
            border-radius: 10px;
            padding: 8px 20px;
            color: #fff;
            font-weight: 600;
            border: none;
            transition: .3s;
        }
        .frosted-btn:hover {
            background-color: #003366;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(0,0,0,0.25);
        }

        .badge-success-custom {
            background-color: rgba(25, 135, 84, 0.85);
        }
        .badge-warning-custom {
            background-color: rgba(255, 193, 7, 0.85);
            color: #222;
        }
        .badge-secondary-custom {
            background-color: rgba(108,117,125,0.85);
        }

        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }

        footer {
            background: #004080;
            color: white;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard.mahasiswa') }}">
                <img src="{{ asset('images/Logo_Politala.png') }}" width="40" class="me-2"> SIPRAKELRA | Mahasiswa
            </a>

            <div class="dropdown ms-auto">
                <a href="#" class="text-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="fw-semibold">{{ Auth::user()->name }}</span> <br>
                    <small>Mahasiswa</small>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><a class="dropdown-item" href="{{ route('mahasiswa.profil') }}"><i class="fas fa-user-edit me-2"></i>Edit Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <main class="container mt-4 mb-5">

        <div class="d-flex justify-content-between flex-wrap align-items-center mb-3">
            <div class="d-flex gap-3 align-items-center">
                <h4 class="fw-bold text-primary mb-0">Data Bimbingan Saya</h4>
                <a href="{{ route('mahasiswa.bimbingan.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Bimbingan
                </a>
            </div>

            {{-- Filter & Search --}}
            <form action="{{ route('mahasiswa.bimbingan.index') }}" method="GET" class="d-flex gap-2">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="Semua" {{ request('status', 'Semua') == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Revisi" {{ request('status') == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                </select>

                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari topik..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
                </div>
            </form>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card frosted-card">
            <div class="card-body">

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Tanggal</th>
                                <th>Topik</th>
                                <th>Dosen Pembimbing</th>
                                <th>Status</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($bimbingans as $index => $bimbingan)
                                <tr>
                                    <td class="text-center">{{ $bimbingans->firstItem() + $index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($bimbingan->tanggal_bimbingan)->isoFormat('D MMM Y') }}</td>
                                    <td>{{ $bimbingan->topik_bimbingan }}</td>
                                    <td>{{ $bimbingan->dosen->nama ?? 'N/A' }}</td>
                                    <td>
                                        @if($bimbingan->status == 'Disetujui')
                                            <span class="badge badge-success-custom">{{ $bimbingan->status }}</span>
                                        @elseif($bimbingan->status == 'Revisi')
                                            <span class="badge badge-warning-custom">{{ $bimbingan->status }}</span>
                                        @else
                                            <span class="badge bg-info text-dark">{{ $bimbingan->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $bimbingan->catatan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3">
                                        <strong>Tidak ada data bimbingan.</strong>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Back + Pagination --}}
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                    <a href="{{ route('dashboard.mahasiswa') }}" class="btn frosted-btn">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <div>
                        {{ $bimbingans->links() }}
                    </div>
                </div>
            </div>
        </div>

    </main>


    <footer>
        <small>&copy; 2025 SIPRAKELRA - Politeknik Negeri Tanah Laut</small>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
