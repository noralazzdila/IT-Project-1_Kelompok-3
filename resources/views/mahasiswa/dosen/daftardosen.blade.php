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
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .header {
            background: #113F67;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.2);
        }
        .footer {
            background: #113F67;
            color: #fff;
            text-align: center;
            padding: 12px;
            margin-top: auto;
        }
        .breadcrumb {
            background-color: transparent;
            padding-left: 0;
            margin-bottom: 15px;
        }
        .table thead {
            background: #113F67;
            color: #fff;
        }
    </style>
</head>
<body>
    {{-- HEADER --}}
    <div class="header">
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/Logo_Politala.png') }}" width="50" alt="Logo" class="me-3">
            <div>
                <h5 class="mb-0 fw-bold">SIPRAKERLA</h5>
                <small>Sistem Informasi PKL</small>
            </div>
        </div>
        <div>
            <span class="fw-semibold">{{ Auth::user()->nama ?? 'Mahasiswa' }}</span>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main class="container mt-4 flex-grow-1">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.mahasiswa') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Dosen</li>
            </ol>
        </nav>

        <div class="card rounded-3 shadow-sm">
            <div class="card-body">
                {{-- Judul dan Form Pencarian --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <h5 class="fw-semibold text-dark mb-0"><i class="fa-solid fa-users me-2"></i>Daftar Dosen</h5>
                    <form action="{{ route('dosen.daftardosen') }}" method="GET" class="d-flex" style="max-width: 300px;">
                        <input type="text" name="search" class="form-control me-2" placeholder="Cari Nama atau NIP..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
                    </form>
                </div>

                {{-- Tabel Data Dosen --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-dark">
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
                                    <td colspan="5" class="text-center">
                                        <div class="alert alert-warning mb-0">
                                            Data Dosen tidak ditemukan atau belum tersedia.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Tombol Kembali di bawah tabel --}}
                <div class="mt-3">
                    <a href="{{ route('dashboard.mahasiswa') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>

            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    <div class="footer">
        <small>&copy; 2025 SIPRAKERLA - Sistem Informasi PKL | Politala</small>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
