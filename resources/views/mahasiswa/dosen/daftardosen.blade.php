<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Dosen | SIPRAKERLA</title>
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

        main {
            flex: 1;
        }

        .navbar {
            background-color: #004080;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .15);
        }
        .navbar-brand, .nav-link {
            color: #ffffff !important;
        }

        .card {
            background: rgba(243, 244, 245, 0.35);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            border: 1px solid rgba(0,64,128,0.3);
            animation: fadeInUp .7s ease forwards;
            transform: translateY(15px);
            opacity: 0;
        }

        .table thead {
            background-color: #004080 !important;
            color: #fff;
        }

        .table tbody tr:hover {
            background: rgba(0,64,128,0.08);
        }

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

    {{-- Header Navbar sama seperti halaman Data Bimbingan --}}
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard.mahasiswa') }}">
                <img src="{{ asset('images/Logo_Politala.png') }}" width="40" class="me-2"> SIPRAKERLA | Mahasiswa
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

    {{-- MAIN CONTENT --}}
    <main class="container mt-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.mahasiswa') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Dosen</li>
            </ol>
        </nav>

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <h5 class="fw-bold text-primary mb-0"><i class="fa-solid fa-users me-2"></i>Daftar Dosen</h5>

                    <form action="{{ route('dosen.daftardosen') }}" method="GET" class="d-flex" style="max-width: 300px;">
                        <input type="text" name="search" class="form-control me-2" placeholder="Cari Nama atau NIP..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-search"></i></button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 60px;">No</th>
                                <th style="width: 150px;">NIP</th>
                                <th>Nama</th>
                                <th style="width: 200px;">Jabatan</th>
                                <th style="width: 200px;">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dosens as $index => $dosen)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $dosen->nip }}</td>
                                    <td>{{ $dosen->nama }}</td>
                                    <td>{{ $dosen->jabatan }}</td>
                                    <td>{{ $dosen->email }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3">
                                        <strong>Data Dosen tidak ditemukan atau belum tersedia.</strong>
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
    </main>

    {{-- FOOTER --}}
    <div class="footer">
        <small>&copy; 2025 SIPRAKERLA - Politeknik Negeri Tanah Laut</small>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
