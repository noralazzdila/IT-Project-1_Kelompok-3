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
    .hero .card-frosted-link {
        text-decoration: none; /* Remove underline */
        color: inherit; /* Inherit color from parent */
        display: block; /* Make the entire link clickable */
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

@php
$notifications = Auth::check() ? Auth::user()->unreadNotifications : collect();
@endphp

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
            <a class="nav-link active" href="{{ route ('dashboard.mahasiswa') }}">Beranda</a>
          </li>
          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="tempatDropdown" data-bs-toggle="dropdown">Tempat PKL</a>
            <ul class="dropdown-menu" aria-labelledby="tempatDropdown">
              <li>
                <div class="dropdown-card">
                    <a href="{{ route('tempatpkl.lihattempatpkl') }}"><i class="bi bi-search me-2"></i>Lihat Tempat PKL</a>
                   <a href="{{ route('tempatpkl.ajukantempatpkl') }}"><i class="bi bi-plus-circle me-2"></i>Ajukan Tempat PKL</a>
                </div>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dosenDropdown" data-bs-toggle="dropdown">Dosen</a>
            <ul class="dropdown-menu" aria-labelledby="dosenDropdown">
              <li>
                <div class="dropdown-card">
                  <a href="{{ route('dosen.daftardosen') }}"><i class="bi bi-person-lines-fill me-2"></i>Daftar Dosen</a>
                  <a href="{{ route('dosen.dosenpembimbing') }}"><i class="bi bi-person-check-fill me-2"></i>Dosen Pembimbing</a>
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
                  <a href="{{ route('mahasiswa.bimbingan.index') }}"><i class="bi bi-journal-text me-2"></i> Konsultasi</a>
                </div>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="proposalDropdown" data-bs-toggle="dropdown">Proposal</a>
            <ul class="dropdown-menu" aria-labelledby="proposalDropdown">
              <li>
                <div class="dropdown-card">
                  <a href="{{ route('mahasiswa.proposal.upload') }}"><i class="bi bi-cloud-upload me-2"></i>Upload Proposal</a>
                </div>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pemberkasanDropdown" data-bs-toggle="dropdown">Pemberkasan</a>
            <ul class="dropdown-menu" aria-labelledby="pemberkasanDropdown">
              <li>
                <div class="dropdown-card">
                  <a href="{{ route('mahasiswa.pemberkasan.upload') }}"><i class="bi bi-folder-plus me-2"></i>Upload Berkas</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>

        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item dropdown me-3">
            <a class="nav-link position-relative" href="#" id="notifDropdown" data-bs-toggle="dropdown">
              <i class="bi bi-bell-fill notif-icon"></i>
              @if($notifications->count() > 0)
              <span class="notif-badge">{{ $notifications->count() }}</span>
              @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown">
              <li>
                <div class="notif-card">
                  <div class="notif-header">
                    <h6>Notifikasi</h6>
                    <form action="{{ route('notifikasi.baca') }}" method="POST">
                      @csrf
                      <button type="submit" class="btn btn-link p-0">
                        Tandai Semua Dibaca
                      </button>
                    </form>
                  </div>
                  <div>
                      <div>
                        @forelse($notifications as $notif)
                        <div class="notif-item">
                          <strong>{{ $notif->data['judul'] }}</strong>
                          <p class="mb-0 small">{{ $notif->data['pesan'] }}</p>
                          <small class="text-muted">
                          {{ $notif->created_at->diffForHumans() }}
                        </small>
                      </div>
                      @empty
                      <div class="notif-item text-center text-muted">
                        Tidak ada notifikasi baru
                      </div>
                      @endforelse
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
              <span>{{ optional(Auth::user())->name ?? 'Pengguna' }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profilDropdown">
              <li>
                <div class="profile-card">
                    <div class="text-center mb-2">
                    <img src="{{ optional(Auth::user())->profile_photo ? asset('storage/' . optional(Auth::user())->profile_photo) : asset('images/user-fill.png') }}" alt="Profil" class="profile-img me-2">
                    <h6>{{ optional(Auth::user())->name ?? 'Pengguna' }}</h6>
                    <p>Mahasiswa-Teknologi Informasi</p>
                  </div>
                    <div class="profile-actions">
                    <a href="{{ route('mahasiswa.profil') }}"><i class="bi bi-person-circle me-2"></i>Profil Saya</a>
                    <a href="{{ route('mahasiswa.pengaturan') }}"><i class="bi bi-gear me-2"></i>Pengaturan</a>
                    <hr>
                    <a href="{{ route('login') }}" class="logout"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a>
                  </div>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-12">
          <h1 class="mb-3">Sistem PKL <span style="color:#4ba3ff;">Mahasiswa</span></h1>
          <p class="mb-4">
            Platform terpadu untuk mengelola seluruh kegiatan Praktik Kerja Lapangan Anda.
            Dari pendaftaran hingga evaluasi, semua dalam satu sistem yang mudah digunakan.
          </p>
          <a href="#" class="btn btn-primary me-2">Mulai PKL</a>
          <a href="{{ asset('documents/Paduan PKL .pdf') }}" class="btn btn-outline-light" target="_blank">Panduan</a>
        </div>
        <div class="col-lg-6 col-md-12 mt-4 mt-lg-0">
          <div class="row g-4">
            <div class="col-md-6">
              <a href="{{ url('/mahasiswa/tempat-pkl-terbaik') }}" class="card-frosted-link">
                <div class="card-frosted">
                  <i class="bi bi-building-fill fs-1 mb-2"></i>
                  <h6>Tempat PKL</h6>
                  <p>Jelajahi berbagai tempat PKL yang tersedia</p>
                </div>
              </a>
            </div>
            </div>
            <div class="col-md-6">
              <div class="card-frosted">
                <i class="bi bi-person-video3 fs-1 mb-2"></i>
                <h6>Dosen Pembimbing</h6>
                <p>Konsultasi dengan dosen pembimbing</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card-frosted">
                <i class="bi bi-file-earmark-text-fill fs-1 mb-2"></i>
                <h6>Proposal</h6>
                <p>Kelola proposal PKL Anda</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card-frosted">
                <i class="bi bi-easel2-fill fs-1 mb-2"></i>
                <h6>Seminar</h6>
                <p>Jadwal dan informasi seminar</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="container main-content">
    <div class="row"> 
      <div class="col-md-8">
        <div class="card p-4 mb-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="mb-0">Tempat PKL Terfavorit</h5>
              <a href="{{ route('mahasiswa.lihatsemua') }}" class="btn btn-sm btn-outline-primary">Lihat Semua <i class="bi bi-arrow-right-short"></i></a>
          </div>

          <div class="ranking-list">
            <div class="ranking-item" data-rank="1">
              <div class="ranking-number">1</div>
              <img src="https://placehold.co/100x100/E30613/FFFFFF?text=Telkom" alt="Logo Telkom" class="ranking-logo">
              <div class="ranking-details">
                <h6>PT. Telkom Indonesia</h6>
                <p><i class="bi bi-geo-alt-fill"></i> Jl. A. Yani Km. 6, Banjarmasin</p>
              </div>
              <a href="#" class="ms-auto btn btn-sm btn-light">Detail</a>
            </div>
            <div class="ranking-item" data-rank="2">
              <div class="ranking-number">2</div>
              <img src="https://placehold.co/100x100/00A5E0/FFFFFF?text=B.Kalsel" alt="Logo Bank Kalsel" class="ranking-logo">
              <div class="ranking-details">
                <h6>Bank Kalsel</h6>
                <p><i class="bi bi-geo-alt-fill"></i> Jl. Lambung Mangkurat No.1, Banjarmasin</p>
              </div>
              <a href="#" class="ms-auto btn btn-sm btn-light">Detail</a>
            </div>
            <div class="ranking-item" data-rank="3">
              <div class="ranking-number">3</div>
              <img src="https://placehold.co/100x100/009647/FFFFFF?text=GoJek" alt="Logo Go-Jek" class="ranking-logo">
              <div class="ranking-details">
                <h6>Go-Jek Office Banjarmasin</h6>
                <p><i class="bi bi-geo-alt-fill"></i> Jl. Gatot Subroto, Banjarmasin</p>
              </div>
              <a href="#" class="ms-auto btn btn-sm btn-light">Detail</a>
            </div>
            <div class="ranking-item" data-rank="4">
              <div class="ranking-number">4</div>
              <img src="https://placehold.co/100x100/231F20/FFFFFF?text=Kominfo" alt="Logo Kominfo" class="ranking-logo">
              <div class="ranking-details">
                <h6>Dinas Kominfo Kalsel</h6>
                <p><i class="bi bi-geo-alt-fill"></i> Jl. Dharma Praja, Banjarbaru</p>
              </div>
              <a href="#" class="ms-auto btn btn-sm btn-light">Detail</a>
            </div>
            <div class="ranking-item" data-rank="5">
              <div class="ranking-number">5</div>
              <img src="https://placehold.co/100x100/00AEEF/FFFFFF?text=PLN" alt="Logo PLN" class="ranking-logo">
              <div class="ranking-details">
                <h6>PLN Wilayah Kalselteng</h6>
                <p><i class="bi bi-geo-alt-fill"></i> Jl. Panglima Batur, Banjarbaru</p>
              </div>
              <a href="#" class="ms-auto btn btn-sm btn-light">Detail</a>
            </div>
          </div>

        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3 mb-3">
          <h6>Hello, Selamat Datang</h6>
          <p class="mb-0">Saat ini Anda berada di Semester 3 dengan IPK 0,00 <a href="{{ route('mahasiswa.lihatdetailipk.index') }}">Lihat Detail</a>.</p>
        </div>

        <div class="card p-3">
          <h6>Kalender Akademik</h6> 
            <iframe 
            src="https://calendar.google.com/calendar/embed?src=rifki.pratama%40mhs.politala.ac.id&ctz=Asia%2FMakassar" 
            style="border: 1px solid #ddd; border-radius: 10px;" 
            width="100%" 
            height="350" 
            frameborder="0" 
            scrolling="no">
        </iframe> 
        </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>