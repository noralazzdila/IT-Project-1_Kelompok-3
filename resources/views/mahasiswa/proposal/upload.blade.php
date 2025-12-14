<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIPRAKERLA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary-color: #0d3b66;
      --light-text: #f8f9fa;
      --dark-text: #343a40;
    }

    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
      padding-top: 80px; /* Offset for fixed navbar */
    }

    /* --- Modern Navbar --- */
    .navbar {
      background-color: rgba(13, 59, 102, 0.8); /* Semi-transparent */
      backdrop-filter: blur(10px); /* Glassmorphism effect */
      -webkit-backdrop-filter: blur(10px);
      padding: 0.7rem 1rem;
      position: fixed; /* Fixed at the top */
      top: 0;
      width: 100%;
      z-index: 1050;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      transition: background-color 0.3s ease;
    }

    .navbar-brand {
      font-family: 'Poppins', sans-serif;
      font-size: 22px;
      font-weight: 600;
      letter-spacing: 1px;
    }
    
    .navbar-brand, .nav-link {
      color: var(--light-text) !important;
      transition: color 0.2s ease, background-color 0.2s ease;
    }
    
    .nav-link {
        font-weight: 500;
        border-radius: 8px;
        margin: 0 4px;
        padding: 8px 12px !important;
    }

    .nav-link:hover, .nav-link.active {
      color: #fff !important;
      background-color: rgba(255, 255, 255, 0.1);
    }
    
    /* --- Modern Dropdown --- */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .dropdown-menu {
      border: none;
      background: transparent;
      padding: 0;
      margin-top: 15px !important; /* Spacing from navbar */
    }

    .dropdown-menu.show {
        animation: fadeIn 0.2s ease-out;
    }

    .dropdown-card, .profile-card, .notif-card {
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(15px);
      border-radius: 12px;
      border: 1px solid #e9ecef;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .dropdown-card {
      width: 220px;
      padding: 10px;
    }

    .dropdown-card a {
      text-decoration: none;
      color: var(--primary-color);
      padding: 10px 12px;
      border-radius: 8px;
      transition: all 0.2s ease;
      font-size: 14px;
      font-weight: 500;
      display: flex;
      align-items: center;
    }
    .dropdown-card a:hover {
      background-color: #eef4ff;
      color: #0056b3;
    }

    /* --- Profile & Notification Dropdown --- */
    .profile-img {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid rgba(255,255,255,0.7);
    }
    .profile-card {
      width: 280px;
      padding: 15px;
    }
    .profile-card h6 { margin-bottom: 2px; font-weight: 600; color: var(--dark-text); }
    .profile-card p { font-size: 13px; color: #6c757d; margin-bottom: 12px; }
    .profile-actions a {
      display: flex; align-items: center; text-decoration: none;
      color: #495057; padding: 8px 10px; border-radius: 8px;
      transition: all 0.2s ease; font-size: 14px;
    }
    .profile-actions a:hover { background-color: #f1f3f5; }
    .profile-actions a.logout { color: #dc3545; font-weight: 500; }
    .profile-actions hr { margin: 8px 0; }

    .notif-icon { font-size: 22px; }
    .notif-badge {
      position: absolute; top: -5px; right: -8px;
      background-color: #e44d5a; border-radius: 50%;
      padding: 2px 6px; font-size: 10px; font-weight: bold;
      border: 2px solid var(--primary-color);
    }
    .notif-card {
      width: 350px; padding: 0;
      max-height: 400px; overflow-y: auto;
    }
    .notif-header {
      padding: 12px 15px; display: flex; justify-content: space-between;
      align-items: center; border-bottom: 1px solid #dee2e6;
    }
    .notif-header h6 { font-size: 16px; margin: 0; font-weight: 600; color: var(--primary-color); }
    .notif-header a { font-size: 13px; color: #0d6efd; text-decoration: none; }
    .notif-item {
      padding: 12px 15px; border-bottom: 1px solid #f1f3f5;
      transition: background-color 0.2s ease; cursor: pointer;
    }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background-color: #f8f9fa; }
    .notif-item strong { color: var(--dark-text); font-size: 14px; font-weight: 600; }
    .notif-item small { color: #6c757d; font-size: 12px; }
    .notif-footer { text-align: center; padding: 12px 0; }
    .notif-footer a { font-size: 14px; text-decoration: none; color: #0d6efd; font-weight: 500;}

    /* --- Hero Section --- */
    .hero {
      height: calc(100vh - 80px); /* Full height minus navbar */
      margin-top: -80px; /* Pull up to fill space behind navbar */
      position: relative;
      color: var(--light-text);
      display: flex;
      align-items: center;
      background: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
    }
    .hero::before {
      content: ""; position: absolute; top: 0; left: 0;
      width: 100%; height: 100%;
      background: linear-gradient(90deg, rgba(13, 59, 102, 0.85) 0%, rgba(0,0,0,0.4) 100%);
      z-index: 1;
    }
    .hero .container { position: relative; z-index: 2; }
    .hero h1 { font-size: 3.2rem; font-weight: 700; }
    .hero p { font-size: 1.1rem; max-width: 500px; opacity: 0.9; }
    .hero .btn { padding: 12px 28px; font-weight: 500; border-radius: 8px; }
    .hero .btn-primary { background-color: #4ba3ff; border: none; }

    /* Frosted cards in hero */
    .hero .card-frosted {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        color: var(--light-text);
    }
    .hero .card-frosted:hover {
        transform: translateY(-8px);
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .hero .card-frosted i { color: #4ba3ff; }
    .hero .card-frosted h6 { margin-top: 10px; font-weight: 600; color: #fff; }
    .hero .card-frosted p { font-size: 0.9rem; color: #e0e0e0; margin-bottom: 0; }

    /* --- Main Content Cards --- */
    .main-content {
        padding: 40px 0;
    }
    .card {
      border-radius: 15px;
      border: 1px solid #e0e0e0;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
      background-color: #ffffff;
      transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    
    /* --- NEW: Ranking List Style --- */
    .ranking-item {
      display: flex;
      align-items: center;
      padding: 12px;
      background-color: #fff;
      border: 1px solid #e9ecef;
      border-radius: 12px;
      margin-bottom: 12px;
      transition: all 0.2s ease-in-out;
    }
    .ranking-item:hover {
      transform: translateY(-3px) scale(1.01);
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      border-color: var(--primary-color);
    }
    .ranking-item .ranking-number {
      font-size: 1.5rem;
      font-weight: 700;
      color: #adb5bd;
      min-width: 40px;
      text-align: center;
    }
    .ranking-item .ranking-logo {
      width: 50px;
      height: 50px;
      object-fit: contain;
      border-radius: 8px;
      margin: 0 15px;
      background-color: #f8f9fa;
      padding: 5px;
      border: 1px solid #dee2e6;
    }
    .ranking-item .ranking-details {
      flex-grow: 1;
    }
    .ranking-item .ranking-details h6 {
      font-weight: 600;
      color: var(--dark-text);
      margin-bottom: 2px;
    }
    .ranking-item .ranking-details p {
      font-size: 0.85rem;
      color: #6c757d;
      margin-bottom: 0;
    }
    .ranking-item[data-rank="1"] .ranking-number { color: #FFD700; /* Gold */ }
    .ranking-item[data-rank="2"] .ranking-number { color: #C0C0C0; /* Silver */ }
    .ranking-item[data-rank="3"] .ranking-number { color: #CD7F32; /* Bronze */ }

  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="{{ asset('images/Logo_Politala.png') }}" alt="Logo" width="45" height="45" class="me-2">
        SIPRAKERLA
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{ route ('dashboard.mahasiswa') }}">Beranda</a>
          </li>
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="tempatDropdown" data-bs-toggle="dropdown">Tempat PKL</a>
            <ul class="dropdown-menu" aria-labelledby="tempatDropdown">
              <li>
                <div class="dropdown-card">
                    <a href="{{ route('mahasiswa.lihatpkl.index') }}"><i class="bi bi-search me-2"></i>Lihat Tempat PKL</a>
                   <a href="{{ route('mahasiswa.suratpengantar.create') }}"><i class="bi bi-plus-circle me-2"></i>Ajukan Tempat PKL</a>
                </div>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dosenDropdown" data-bs-toggle="dropdown">Dosen</a>
            <ul class="dropdown-menu" aria-labelledby="dosenDropdown">
              <li>
                <div class="dropdown-card">
                  <a href="#"><i class="bi bi-person-lines-fill me-2"></i>Daftar Dosen</a>
                  <a href="#"><i class="bi bi-person-check-fill me-2"></i>Dosen Pembimbing</a>
                </div>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="seminarDropdown" data-bs-toggle="dropdown">Seminar</a>
            <ul class="dropdown-menu" aria-labelledby="seminarDropdown">
              <li>
                <div class="dropdown-card">
                  <a href="#"><i class="bi bi-calendar-event me-2"></i>Jadwal Seminar</a>
                </div>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="bimbinganDropdown" data-bs-toggle="dropdown">Bimbingan</a>
            <ul class="dropdown-menu" aria-labelledby="bimbinganDropdown">
              <li>
                <div class="dropdown-card">
                  <a href="#"><i class="bi bi-journal-text me-2"></i>Lihat Bimbingan</a>
                </div>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="proposalDropdown" data-bs-toggle="dropdown">Proposal</a>
            <ul class="dropdown-menu" aria-labelledby="proposalDropdown">
              <li>
                <div class="dropdown-card">
                  <a href="#"><i class="bi bi-cloud-upload me-2"></i>Upload Proposal</a>
                  <a href="#"><i class="bi bi-file-earmark-check me-2"></i>Status Proposal</a>
                </div>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pemberkasanDropdown" data-bs-toggle="dropdown">Pemberkasan</a>
            <ul class="dropdown-menu" aria-labelledby="pemberkasanDropdown">
              <li>
                <div class="dropdown-card">
                  <a href="#"><i class="bi bi-folder-plus me-2"></i>Upload Berkas</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>

        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item dropdown me-3">
            <a class="nav-link position-relative" href="#" id="notifDropdown" data-bs-toggle="dropdown">
              <i class="bi bi-bell-fill notif-icon"></i>
              <span class="notif-badge">4</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown">
              <li>
                <div class="notif-card">
                  <div class="notif-header">
                    <h6>Notifikasi</h6>
                    <a href="#">Tandai Semua Dibaca</a>
                  </div>
                  <div>
                    
                  <div class="notif-footer">
                    <a href="#">Lihat Semua Notifikasi</a>
                  </div>
                </div>
              </li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center p-1 pe-2" style="background-color: rgba(255,255,255,0.1); border-radius: 20px;" href="#" id="profilDropdown" data-bs-toggle="dropdown">
              <img src="{{ asset('images/user-fill.png') }}" alt="Profil" class="profile-img me-2">
              <span>Rifki Pratama</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profilDropdown">
              <li>
                <div class="profile-card">
                  <div class="text-center mb-2">
                    <img src="{{ asset('images/user-fill.png') }}" alt="Profil" class="profile-img mb-2" style="width:60px; height:60px; border-width: 3px;">
                    <h6>Rifki Pratama</h6>
                    <p>Mahasiswa - Teknologi Informasi</p>
                  </div>
                  <div class="profile-actions">
                    <a href="#"><i class="bi bi-person-circle me-2"></i>Profil Saya</a>
                    <a href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a>
                    <hr>
                    <a href={{ route('login') }} class="logout"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a>
                  </div>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
        {{-- Konten Navbar Anda bisa diletakkan di sini --}}
    </nav>

    <div class="container main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Status Pengajuan Proposal</h2>
            
            @if($proposals->isEmpty())
                {{-- Tampilkan tombol HANYA jika mahasiswa BELUM pernah upload --}}
                <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#uploadProposalModal">
                    <i class="bi bi-cloud-upload-fill me-2"></i> Upload Proposal Baru
                </button>
            @else
                {{-- Jika sudah, nonaktifkan tombol --}}
                <button type="button" class="btn btn-success btn-lg" disabled>
                    <i class="bi bi-check-circle-fill me-2"></i> Proposal Telah Diupload
                </button>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if ($errors->has('nim'))
            <div class="alert alert-danger">
                Gagal: Anda sudah pernah mengupload proposal. Anda tidak dapat mengupload proposal baru.
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Judul Proposal</th>
                                <th>Pembimbing</th>
                                <th>Tempat PKL</th>
                                <th>Tgl. Pengajuan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($proposals as $proposal)
                            <tr>
                                <td><strong>{{ $proposal->judul_proposal }}</strong></td>
                                <td>{{ $proposal->pembimbing }}</td>
                                <td>{{ $proposal->tempat_pkl }}</td>
                                <td>{{ \Carbon\Carbon::parse($proposal->tanggal_pengajuan)->translatedFormat('d F Y') }}</td>
                                <td class="text-center">
                                    @php
                                        $badgeClass = match($proposal->status) {
                                            'Menunggu' => 'bg-warning text-dark',
                                            'Disetujui' => 'bg-success',
                                            'Ditolak'  => 'bg-danger',
                                            default    => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge rounded-pill {{ $badgeClass }}">{{ $proposal->status }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('proposal.file', $proposal) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Anda belum mengupload proposal.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadProposalModal" tabindex="-1" aria-labelledby="uploadProposalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="uploadProposalModalLabel">Formulir Upload Proposal PKL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('mahasiswa.proposal.store') }}" method="POST" enctype="multipart/form-data" id="form-proposal">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" name="nim" value="2062201015" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                                <input type="text" class="form-control" name="nama_mahasiswa" value="Rifki Pratama" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="judul_proposal" class="form-label">Judul Proposal</label>
                            <input type="text" class="form-control @error('judul_proposal') is-invalid @enderror" name="judul_proposal" value="{{ old('judul_proposal') }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pembimbing" class="form-label">Dosen Pembimbing</label>
                                <input type="text" class="form-control @error('pembimbing') is-invalid @enderror" name="pembimbing" value="{{ old('pembimbing') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tempat_pkl" class="form-label">Tempat PKL</label>
                                <input type="text" class="form-control @error('tempat_pkl') is-invalid @enderror" name="tempat_pkl" value="{{ old('tempat_pkl') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="file_proposal" class="form-label">Upload File (PDF, maks. 5MB)</label>
                                <input class="form-control @error('file_proposal') is-invalid @enderror" type="file" name="file_proposal" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                                <input type="date" class="form-control" name="tanggal_pengajuan" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" name="catatan" rows="2" placeholder="Catatan singkat untuk Koordinator PKL...">{{ old('catatan') }}</textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="form-proposal" class="btn btn-primary">Upload Sekarang</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>