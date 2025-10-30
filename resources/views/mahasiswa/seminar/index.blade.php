<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jadwal Seminar PKL</title>
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
    .seminar-card {
      border-left: 5px solid var(--primary-color);
      transition: all 0.3s ease;
    }
    .seminar-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .seminar-card .card-title {
      font-weight: 600;
      margin-bottom: 15px;
    }
    .seminar-details li {
      margin-bottom: 8px;
      font-size: 0.95rem;
      color: var(--dark-text);
    }
    .seminar-details li i {
      color: var(--primary-color);
      width: 20px;
      text-align: center;
    }
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
            <a class="nav-link" href="{{ route('dashboard.mahasiswa') }}">Beranda</a>
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
            <a class="nav-link dropdown-toggle active" href="#" id="seminarDropdown" data-bs-toggle="dropdown">Seminar</a>
            <ul class="dropdown-menu" aria-labelledby="seminarDropdown">
              <li>
                <div class="dropdown-card">
                  <a href="{{ route('mahasiswa.seminar.jadwal') }}"><i class="bi bi-calendar-event me-2"></i>Jadwal Seminar</a>
                  <a href="#"><i class="bi bi-card-checklist me-2"></i>Daftar Seminar</a>
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
                      <div class="notif-item">
                        <strong>Bimbingan Dijadwalkan</strong>
                        <p class="mb-0 small">Bimbingan dengan Dr. Sari Wijaya pada 15 Januari 2024, 10:00 WIB</p>
                        <small class="text-muted">2 jam yang lalu</small>
                      </div>
                      <div class="notif-item">
                        <strong>Proposal Disetujui</strong>
                        <p class="mb-0 small">Proposal PKL Anda telah disetujui oleh dosen pembimbing.</p>
                        <small class="text-muted">1 hari yang lalu</small>
                      </div>
                      <div class="notif-item">
                        <strong>Deadline Mendekati</strong>
                        <p class="mb-0 small">Pengumpulan laporan PKL dalam 3 hari lagi.</p>
                        <small class="text-muted">2 hari yang lalu</small>
                      </div>
                      <div class="notif-item">
                        <strong>Seminar Terjadwal</strong>
                        <p class="mb-0 small">Seminar PKL Anda telah dijadwalkan oleh admin.</p>
                        <small class="text-muted">3 hari yang lalu</small>
                      </div>
                  </div>
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

  <div class="container main-content">
    <h2 class="fw-bold mb-4">Jadwal Seminar PKL</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @forelse ($seminars as $seminar)
            <div class="col-md-6 mb-4">
                <div class="card seminar-card h-100">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $seminar->judul }}</h5>
                        <p class="card-text text-muted mb-2">
                            <i class="bi bi-person-fill me-2"></i>Mahasiswa: <strong>{{ $seminar->nama_mahasiswa }}</strong> ({{ $seminar->nim }})
                        </p>
                        <ul class="list-unstyled seminar-details">
                            <li><i class="bi bi-person-badge me-2"></i>Pembimbing: {{ $seminar->nama_pembimbing }}</li>
                            <li><i class="bi bi-person-check me-2"></i>Penguji: {{ $seminar->nama_penguji }}</li>
                            <li><i class="bi bi-calendar-event me-2"></i>Jadwal: {{ \Carbon\Carbon::parse($seminar->tanggal)->isoFormat('dddd, D MMMM Y') }}</li>
                            <li><i class="bi bi-clock me-2"></i>Waktu: {{ date('H:i', strtotime($seminar->jam_mulai)) }} - {{ date('H:i', strtotime($seminar->jam_selesai)) }}</li>
                            <li><i class="bi bi-geo-alt me-2"></i>Ruang: {{ $seminar->ruang }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    Belum ada data seminar yang dijadwalkan.
                </div>
            </div>
        @endforelse
    </div>
    {{-- Link Paginasi --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $seminars->links() }}
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>