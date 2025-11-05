<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Bimbingan Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
        }
        .navbar {
            background-color: #113F67;
        }
        .navbar-brand, .navbar-nav .nav-link, .navbar-text {
            color: white !important;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .table th {
            background-color: #113F67;
            color: white;
        }
        footer {
            background: #113F67;
            color: white;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- Navbar Header --}}
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="#">
                <img src="{{ asset('images/Logo_Politala.png') }}" width="40" class="me-2" alt="Logo">
                SIPRAKELRA | Mahasiswa
            </a>
            <div class="dropdown ms-auto">
                <a href="#" class="d-block text-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="fw-semibold">{{ Auth::user()->name }}</span> <br>
                    <small>Mahasiswa</small>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit me-2"></i>Edit Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <h4 class="fw-bold">Data Bimbingan Saya</h4>
            <form action="{{ route('mahasiswa.bimbingan.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                <select name="status" class="form-select" onchange="this.form.submit()" style="width:auto;">
                    <option value="Semua" {{ request('status', 'Semua') == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Revisi" {{ request('status') == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                </select>
                <div class="input-group" style="width:auto;">
                    <input type="text" name="search" class="form-control" placeholder="Cari topik bimbingan..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
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
                                    <td>{{ $bimbingan->dosen_pembimbing }}</td>
                                    <td>
                                        @if($bimbingan->status == 'Disetujui')
                                            <span class="badge bg-success">{{ $bimbingan->status }}</span>
                                        @elseif($bimbingan->status == 'Revisi')
                                            <span class="badge bg-warning text-dark">{{ $bimbingan->status }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $bimbingan->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $bimbingan->catatan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="alert alert-warning mb-0">
                                            Belum ada data bimbingan.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Tombol Kembali di bawah tabel -->
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                    <a href="{{ route('dashboard.mahasiswa') }}" class="btn btn-outline-secondary">
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
        <small>&copy; 2025 SIPRAKELRA - Mahasiswa | Politala</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
