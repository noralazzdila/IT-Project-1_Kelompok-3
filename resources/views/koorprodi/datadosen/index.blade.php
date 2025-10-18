<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Dosen</title>
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
                <a href="{{ route('koorprodi.index') }}" class="nav-link"><i class="fa fa-home me-2"></i> Beranda</a>
                <a href="{{ route('koorprodi.user.index') }}" class="nav-link"><i class="fa fa-users me-2"></i> Kelola User</a>
                <a href="{{ route('koorprodi.datamahasiswa.index') }}" class="nav-link"><i class="fa fa-id-card me-2"></i> Kelola Data Mahasiswa</a>
                <a href="{{ route('koorprodi.penguji.index') }}" class="nav-link"><i class="fa fa-user-check me-2"></i> Kelola Penguji</a>
                <a href="{{ route('koorprodi.datadosen.index') }}" class="nav-link active"><i class="fa fa-users me-2"></i> Kelola Data Dosen</a>
                <a href="{{ route('koorprodi.proposal.index') }}" class="nav-link"><i class="fa fa-file-signature me-2"></i> Proposal</a>
            </nav>
        </div>

        <div class="col-10 d-flex flex-column">
            <div class="header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Manajemen Data Dosen</h5>
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fw-semibold">Jaka Permadi, S.Si., M.Cs</span> <br>
                        <small>Koordinator Program Studi</small>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit me-2"></i>Edit Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="{{ route('login') }}"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
            <main class="container-fluid mt-4 flex-grow-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('koorprodi.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola Dosen</li>
                    </ol>
                </nav>
                <div class="card rounded-3 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <a href="{{ route('koorprodi.datadosen.create') }}" class="btn btn-success">
                                <i class="fa-solid fa-plus me-2"></i> Tambah Dosen
                            </a>
                            <form action="{{ route('koorprodi.datadosen.index') }}" method="GET" class="d-flex" style="max-width: 300px;">
                                <input type="text" name="search" class="form-control me-2" placeholder="Cari Nama atau NIP..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
                            </form>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dosens as $index => $dosen)
                                        <tr>
                                            <td class="text-center">{{ $dosens->firstItem() + $index }}</td>
                                            <td>{{ $dosen->nip }}</td>
                                            <td>{{ $dosen->nama }}</td>
                                            <td>{{ $dosen->jabatan }}</td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" action="{{ route('koorprodi.datadosen.destroy', $dosen->id) }}" method="POST">
                                                    <a href="{{ route('koorprodi.datadosen.show', $dosen->id) }}" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                                                    <a href="{{ route('koorprodi.datadosen.edit', $dosen->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                            </td>
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
                         <div class="mt-3">
                            {{ $dosens->links() }}
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