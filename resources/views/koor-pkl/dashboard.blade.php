<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Koordinator PKL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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
            box-shadow: 2px 0 6px rgba(0,0,0,0.1); /* 👉 Shadow sidebar */
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
        /* Card Dashboard */
        .card-dashboard {
            cursor: pointer;
            transition: 0.3s;
            border: none;
            border-radius: 12px;
        }
        .card-dashboard:hover {
            transform: translateY(-5px);
            box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
        }
        .card-dashboard i {
            font-size: 35px;
            color: #113F67;
        }
        /* Footer */
        .footer {
            background: #113F67;
            color: #fff;
            padding: 12px;
            text-align: center;
            margin-top: auto;
        }

        /* */
        .custom-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .custom-list li {
            display: flex;
            align-items: center;
            padding: 12px 5px;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s ease-in-out;
        }
        .custom-list li:hover {
            background-color: #f8f9fa;
        }
        .custom-list li:last-child {
            border-bottom: none;
        }
        .custom-list .list-icon {
            font-size: 1.2rem;
            width: 40px;
            text-align: center;
        }
        .custom-list .list-content {
            flex-grow: 1;
            margin-left: 10px;
        }
        .custom-list .list-content p {
            margin: 0;
            line-height: 1.4;
        }

        .scrollable-content {
            height: 220px; /* Sedikit menambah tinggi */
            overflow-y: auto;
        }
        .seminar-entry {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .seminar-entry .student-info {
            font-size: 1.1rem;
            font-weight: 600;
        }
        .seminar-entry .student-info small {
            font-weight: 400;
            color: #6c757d;
        }
        .seminar-entry .judul {
            font-style: italic;
            color: #343a40;
            margin: 8px 0;
        }
        .seminar-details, .seminar-roles {
            font-size: 0.9rem;
            color: #495057;
        }
        .seminar-details i, .seminar-roles i {
            width: 20px;
            text-align: center;
            color: #113F67;
        }

    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="col-2 sidebar">
            <div class="text-center mb-4">
                <img src="{{ asset('images/Logo_Politala.png') }}" width="80" alt="Logo">
                <h6 class="fw-bold mt-2">SIPRAKELRA</h6>
                <small class="text-muted">Sistem Informasi PKL</small>
            </div>
            <nav class="nav flex-column px-2">
                <a href="{{ route('koor.dashboard') }}" class="nav-link active"><i class="fa fa-home me-2"></i> Beranda</a>
                <a href="{{ route('user.index') }}" class="nav-link"><i class="fa fa-users me-2"></i>User</a>
                <a href="{{ route('nilai.index') }}" class="nav-link"><i class="fa fa-graduation-cap me-2"></i>Nilai</a>
                <a href="{{ route('tempatpkl.index') }}" class="nav-link"><i class="fa fa-building me-2"></i>Tempat PKL</a>
                <a href="{{ route('datamahasiswa.index') }}" class="nav-link"><i class="fa fa-id-card me-2"></i>Data Mahasiswa</a>
                <a href="{{ route('bimbingan.index') }}" class="nav-link"><i class="fa fa-chalkboard-teacher me-2"></i>Bimbingan</a>
                <a href="{{ route('seminar.index') }}" class="nav-link "><i class="fa fa-calendar me-2"></i>Seminar</a>
                <a href="{{ route('penguji.index') }}" class="nav-link"><i class="fa fa-user-check me-2"></i>Penguji</a>
                <a href="{{ route('datadosen.index') }}" class="nav-link"><i class="fa fa-users me-2"></i>Data Dosen</a>
                <a href="{{ route('proposal.index') }}" class="nav-link "><i class="fa fa-file-signature me-2"></i>Proposal</a>
                <a href="{{ route('suratpengantar.index') }}" class="nav-link "><i class="fa fa-envelope me-2"></i>Surat Pengantar</a>
                <a href="{{ route('pemberkasan.index') }}" class="nav-link"><i class="fa fa-folder me-2"></i>Pemberkasan</a>
            </nav>
            </nav>
        </div>
  <div class="col-10 d-flex flex-column">
            <div class="header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Dashboard Koordinator PKL</h5>
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

            <div class="container-fluid mt-4 flex-grow-1 px-4">
                {{-- 🔔 TEST NOTIFIKASI EMAIL KE MAHASISWA --}}
                @if(auth()->check())
                @if(session('success'))
                <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <form action="{{ route('dashboard.test.notifikasi') }}" method="POST" class="mb-3">
                @csrf
                <button type="submit" class="btn btn-warning">
                    🔔 Test Kirim Email ke Mahasiswa
                </button>
            </form>
            @endif
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="#" class="text-decoration-none text-dark">
                            <div class="card card-dashboard text-center p-3 shadow-sm">
                                <i class="fa fa-user-graduate mb-2"></i>
                                <h6>Mahasiswa Memenuhi Syarat PKL</h6>
                                <h4>100</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="text-decoration-none text-dark">
                            <div class="card card-dashboard text-center p-3 shadow-sm">
                                <i class="fa fa-file-signature mb-2"></i>
                                <h6>Acc Pengajuan Proposal</h6>
                                <h4>10</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="text-decoration-none text-dark">
                            <div class="card card-dashboard text-center p-3 shadow-sm">
                                <i class="fa fa-building-columns mb-2"></i>
                                <h6>Acc Pengajuan Tempat PKL</h6>
                                <h4>100</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="#" class="text-decoration-none text-dark">
                            <div class="card card-dashboard text-center p-3 shadow-sm">
                                <i class="fa fa-calendar-days mb-2"></i>
                                <h6>Seminar Bulan Ini</h6>
                                <h4>10</h4>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h6 class="fw-bold mb-0">Aktivitas Terbaru</h6>
                            </div>
                            <div class="card-body scrollable-content">
                                <ul class="list-group">
                                @php
                                function getIcon($type) {
                                return match($type) {
                                'dokumen' => '📄',
                                'proposal' => '📝',
                                'seminar' => '🗓️',
                                'proposal_validation' => '✅',
                                default => 'ℹ️',
                                };
                            }
                            @endphp
                            @foreach($activities as $act)
                            <li class="list-group-item d-flex align-items-start">
                                <span class="me-2">{{ getIcon($act->type) }}</span>
                                <div>
                                    <strong>{{ $act->user->name }}</strong> {{ $act->activity }}
                                    <br>
                                    <small>{{ $act->created_at->diffForHumans() }}</small>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <h6 class="fw-bold mb-0">Jadwal Seminar </h6>
                            </div>
                            <div class="card-body scrollable-content">
                                @forelse ($seminars as $seminar)
                                <div class="seminar-entry">
                                    <div class="student-info">
                                        {{ $seminar->nama_mahasiswa ?? '-' }}
                                        <small class="d-block">NIM: {{ $seminar->nim ?? '-' }}</small>
                                    </div>
                                    <p class="judul">"{{ $seminar->judul ?? 'Judul tidak tersedia' }}"</p>
                                    <div class="seminar-details">
                                        <p class="mb-1"><i class="fas fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($seminar->tanggal)->translatedFormat('l, d F Y') }}</p>
                                        <p class="mb-1"><i class="fas fa-clock me-2"></i>{{ $seminar->jam_mulai }} - {{ $seminar->jam_selesai }}</p>
                                        <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>{{ $seminar->ruang }}</p>
                                    </div>
                                    <hr class="my-2">
                                    <div class="seminar-roles">
                                        <p class="mb-1"><strong>Pembimbing:</strong> {{ $seminar->nama_pembimbing ?? '-' }}</p>
                                        <p class="mb-0"><strong>Penguji:</strong> {{ $seminar->nama_penguji ?? '-' }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center p-4">
                                    <p class="mb-0">Belum ada jadwal seminar.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    </div>
             </div>
            <div class="footer">
                <small>&copy; 2025 SIPRAKELRA - Sistem Informasi PKL | Politala</small>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>