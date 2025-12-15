<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Proposal | SIPRAKERLA</title>
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
            to { opacity:1; transform:translateY(0); }
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

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard.mahasiswa') }}">
                <img src="{{ asset('images/Logo_Politala.png') }}" width="40" class="me-2">
                SIPRAKERLA | Mahasiswa
            </a>

            <div class="dropdown ms-auto">
                <a href="#" class="text-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <span class="fw-semibold">{{ Auth::user()->name }}</span> <br>
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

    <!-- Main -->
    <main class="container mt-4 mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.mahasiswa') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Status Proposal</li>
            </ol>
        </nav>

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <h5 class="fw-bold text-primary mb-0">
                        <i class="fa-solid fa-file-lines me-2"></i>Status Proposal PKL
                    </h5>

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadProposalBaru">
                        <i class="fa-solid fa-upload me-1"></i> Upload Proposal Baru
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px;">No</th>
                                <th>Judul Proposal</th>
                                <th>Status</th>
                                <th>Pembimbing</th>
                                <th>Proposal</th>
                                <th class="text-center" style="width:180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
    @forelse ($proposals as $proposal)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td> <!-- No -->
            <td>{{ $proposal->judul_proposal }}</td>           <!-- Judul Proposal -->
            <td>{{ ucfirst($proposal->status ?? '-') }}</td>  <!-- Status -->
            <td>{{ $proposal->pembimbing }}</td>             <!-- Pembimbing -->
            <td>
                @if ($proposal->file_proposal)
                    <a href="{{ route('proposal.lihat', $proposal->id) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="fa-solid fa-file-pdf me-1"></i> Lihat Proposal
                    </a>
                @else
                    <span class="text-muted">Belum upload</span>
                @endif
            </td> <!-- Proposal -->
            <td class="text-center"> <!-- Aksi -->
                @if ($proposal->file_proposal)
                    <button class="btn btn-secondary btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#uploadProposal{{ $proposal->id }}">
                        <i class="fa-solid fa-upload me-1"></i> Upload Ulang
                    </button>
                @else
                    <button class="btn btn-primary btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#uploadProposal{{ $proposal->id }}">
                        <i class="fa-solid fa-upload me-1"></i> Upload Proposal
                    </button>
                @endif

                @if ($proposal->status == 'diterima')
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $proposal->id }}">
                        <i class="fa-solid fa-upload me-1"></i> Upload Berkas
                    </button>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center py-3 text-danger fw-bold">
                Belum ada status proposal.
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

    <!-- Modal Upload Proposal Baru -->
    <div class="modal fade" id="uploadProposalBaru" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Upload Proposal Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('mahasiswa.proposal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="judul_proposal" class="form-control mb-2" placeholder="Judul Proposal" required>
                        <input type="text" name="pembimbing" class="form-control mb-2" placeholder="Pembimbing" required>
                        <input type="text" name="tempat_pkl" class="form-control mb-2" placeholder="Tempat PKL" required>
                        <input type="file" name="file_proposal" class="form-control" accept="application/pdf" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Loop untuk Upload Proposal & Upload Berkas -->
    @foreach ($proposals as $proposal)
    <!-- Modal Upload Proposal -->
    <div class="modal fade" id="uploadProposal{{ $proposal->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Upload Proposal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('mahasiswa.proposal.upload', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label class="form-label fw-semibold">File Proposal (PDF)</label>
                        <input type="file" name="file_proposal" class="form-control" accept="application/pdf" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Upload Berkas -->
    <div class="modal fade" id="uploadModal{{ $proposal->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Upload Berkas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('mahasiswa.proposal.upload', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label class="form-label fw-semibold">File Surat Penerimaan (PDF)</label>
                        <input type="file" name="file_surat" class="form-control" accept="application/pdf" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Footer -->
    <div class="footer">
        <small>&copy; 2025 SIPRAKERLA - Politeknik Negeri Tanah Laut</small>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
