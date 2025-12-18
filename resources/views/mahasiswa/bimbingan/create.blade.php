<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Bimbingan | Mahasiswa</title>

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
            box-shadow: 0 3px 12px rgba(0, 0, 0, .15);
        }
        .navbar-brand, .nav-link { color: #ffffff !important; }

        .frosted-card {
            background: rgba(255,255,255,0.4);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            border: 1px solid rgba(0,64,128,0.3);
            animation: fadeInUp .7s ease forwards;
            transform: translateY(15px);
            opacity: 0;
        }

        .form-label { font-weight: 600; color: #004080; }

        .btn-primary {
            background-color: #004080;
            border-color: #004080;
            transition: .3s;
        }
        .btn-primary:hover {
            background-color: #003366;
            border-color: #003366;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(0,0,0,0.25);
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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.mahasiswa') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('mahasiswa.bimbingan.index') }}">Data Bimbingan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Bimbingan</li>
            </ol>
        </nav>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card frosted-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Formulir Tambah Bimbingan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('mahasiswa.bimbingan.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="tanggal_bimbingan" class="form-label">Tanggal Bimbingan</label>
                                <input type="date" class="form-control @error('tanggal_bimbingan') is-invalid @enderror" id="tanggal_bimbingan" name="tanggal_bimbingan" value="{{ old('tanggal_bimbingan') }}" required>
                                @error('tanggal_bimbingan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dosen_pembimbing" class="form-label">Dosen Pembimbing</label>
                                <select class="form-select @error('dosen_pembimbing') is-invalid @enderror" id="dosen_pembimbing" name="dosen_pembimbing" required>
                                    <option value="" disabled selected>Pilih Dosen Pembimbing</option>
                                    @foreach($dosens as $dosen)
                                        <option value="{{ $dosen->id }}" {{ old('dosen_pembimbing') == $dosen->id ? 'selected' : '' }}>{{ $dosen->nama }}</option>
                                    @endforeach
                                </select>
                                @error('dosen_pembimbing')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="topik_bimbingan" class="form-label">Topik Bimbingan</label>
                                <textarea class="form-control @error('topik_bimbingan') is-invalid @enderror" id="topik_bimbingan" name="topik_bimbingan" rows="4" placeholder="Contoh: Revisi Bab 1 dan 2, Diskusi progres..." required>{{ old('topik_bimbingan') }}</textarea>
                                @error('topik_bimbingan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('mahasiswa.bimbingan.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
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
