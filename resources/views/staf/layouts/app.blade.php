
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Staf')</title>
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
        .header {
            background: #113F67;
            color: #fff;
            padding: 15px;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.2);
        }
        .footer {
            background: #113F67;
            color: #fff;
            padding: 12px;
            text-align: center;
            margin-top: auto;
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
                 <a href="{{ route('staf.index') }}" class="nav-link {{ request()->routeIs('staf.index') ? 'active' : '' }}"><i class="fa fa-home me-2"></i> Beranda</a>
                <a href="{{ route('staf.datamahasiswa.index') }}" class="nav-link {{ request()->routeIs('staf.datamahasiswa.*') ? 'active' : '' }}"><i class="fa fa-id-card me-2"></i>Data Mahasiswa</a>
                <a href="{{ route('staf.datadosen.index') }}" class="nav-link {{ request()->routeIs('staf.datadosen.*') ? 'active' : '' }}"><i class="fa fa-users me-2"></i>Data Dosen</a>
                <a href="{{ route('staf.tempatpkl.index') }}" class="nav-link {{ request()->routeIs('staf.tempatpkl.*') ? 'active' : '' }}"><i class="fa fa-building me-2"></i>Tempat PKL</a>
                <a href="{{ route('staf.nilai.index') }}" class="nav-link {{ request()->routeIs('staf.nilai.*') ? 'active' : '' }}"><i class="fa fa-graduation-cap me-2"></i>Nilai</a>
                <a href="{{ route('staf.seminar.index') }}" class="nav-link {{ request()->routeIs('staf.seminar.*') ? 'active' : '' }}"><i class="fa fa-calendar-check me-2"></i>Seminar</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-10 d-flex flex-column">
            <!-- Header -->
            <div class="header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">@yield('header-title', 'Dashboard Staf')</h5>
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fw-semibold">{{ Auth::user()->name ?? 'Nama Staf' }}</span> <br>
                        <small>{{ ucfirst(Auth::user()->role ?? 'staf') }}</small>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit me-2"></i>Edit Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="{{ route('login') }}"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>

            <!-- Content -->
            <div class="container-fluid mt-4 flex-grow-1 px-4">
                @yield('content')
            </div>

            <!-- Footer -->
            <div class="footer">
                <small>&copy; 2025 SIPRAKELRA - Sistem Informasi PKL | Politala</small>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
