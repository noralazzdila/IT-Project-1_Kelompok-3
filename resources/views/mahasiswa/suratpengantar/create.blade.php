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
                     <a href="{{ route('seminar.jadwal') }}"><i class="bi bi-calendar-event me-2"></i>Jadwal Seminar</a>
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
                  <a href="{{ route('mahasiswa.proposal.create')  }}"><i class="bi bi-cloud-upload me-2"></i>Upload Proposal</a>
                </div>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pemberkasanDropdown" data-bs-toggle="dropdown">Pemberkasan</a>
            <ul class="dropdown-menu" aria-labelledby="pemberkasanDropdown">
              <li>
                <div class="dropdown-card">
                  <a href="{{ route('mahasiswa.pemberkasan.create') }}"><i class="bi bi-folder-plus me-2"></i>Upload Berkas</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
        
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
  

    <div class="container main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Riwayat Pengajuan Surat Pengantar</h2>
            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#ajukanPklModal">
                <i class="bi bi-plus-circle-fill me-2"></i> Ajukan Tempat PKL Baru
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tempat PKL</th>
                                <th>Alamat</th>
                                <th>Tanggal Pengajuan</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($submissions as $index => $sub)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $sub->tempat_pkl }}</strong></td>
                                <td>{{ Str::limit($sub->alamat_perusahaan, 50) }}</td>
                                <td>{{ \Carbon\Carbon::parse($sub->tanggal_pengajuan)->translatedFormat('d F Y') }}</td>
                                <td class="text-center">
                                    @php
                                        $badgeClass = match($sub->status) {
                                            'Menunggu' => 'bg-warning text-dark',
                                            'Diproses' => 'bg-primary',
                                            'Selesai'  => 'bg-success',
                                            default    => 'bg-secondary',
                                        };
                                    @endphp
                                    <span class="badge rounded-pill {{ $badgeClass }}">{{ $sub->status }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Anda belum pernah mengajukan surat pengantar.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajukanPklModal" tabindex="-1" aria-labelledby="ajukanPklModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="ajukanPklModalLabel">Formulir Surat Pengantar Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('mahasiswa.suratpengantar.store') }}" method="POST" enctype="multipart/form-data" id="form-pengajuan">
                        @csrf
                        
                        {{-- KOLOM NIM DAN NAMA DITAMBAHKAN KEMBALI --}}
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
                            <label for="prodi" class="form-label">Program Studi</label>
                            <input type="text" class="form-control" name="prodi" value="Teknologi Informasi" required>
                        </div>
                        <div class="mb-3">
                            <label for="tempat_pkl" class="form-label">Tempat PKL</label>
                            <input type="text" class="form-control" name="tempat_pkl" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_perusahaan" class="form-label">Alamat Perusahaan</label>
                            <textarea class="form-control" name="alamat_perusahaan" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                            <input type="date" class="form-control" name="tanggal_pengajuan" value="{{ date('Y-m-d') }}" required>
                        </div>
                         <div class="mb-3">
                            <label for="file_surat" class="form-label">Upload Dokumen Pendukung (PDF, maks. 5MB) (Opsional)</label>
                            <input class="form-control" type="file" name="file_surat">
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" name="catatan" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="form-pengajuan" class="btn btn-primary">Kirim Pengajuan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>