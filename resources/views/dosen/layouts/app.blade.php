<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIPRAKELRA - Dosen')</title>
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
        /* Card Dashboard (specific to dashboard, might move to specific views) */
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
        /* Custom breadcrumb */
        .breadcrumb {
             background-color: transparent;
             padding-left: 0;
        }
        /* Custom List (specific to dashboard, might move to specific views) */
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
            height: 220px;
            overflow-y: auto;
        }
        .scrollable-content::-webkit-scrollbar {
            width: 6px;
        }
        .scrollable-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .scrollable-content::-webkit-scrollbar-thumb {
            background: #113F67;
            border-radius: 10px;
        }
        .scrollable-content::-webkit-scrollbar-thumb:hover {
            background: #0d304f;
        }

        /* Styles for forms, tables, etc., that might be common */
        .card {
            border: 0;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.1);
            border-radius: 12px; /* Consistent rounded corners */
        }
        .card-header {
            border-bottom: 1px solid rgba(0,0,0,.125);
            background-color: #f8f9fa; /* Light background for card headers */
            font-weight: bold;
        }
        .table-responsive {
            margin-top: 1rem;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.05);
        }
        .btn {
            border-radius: 8px; /* Consistent rounded buttons */
        }
        .form-control, .form-select {
            border-radius: 8px; /* Consistent rounded form elements */
        }
    </style>
    @stack('styles')
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
                <a href="{{ route('dosen.dashboard') }}" class="nav-link {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}"><i class="fa fa-home me-2"></i> Beranda</a>
                <a href="{{ route('dosen.nilai.indexdosen') }}" class="nav-link {{ request()->routeIs('dosen.nilai.*') ? 'active' : '' }}"><i class="fa fa-graduation-cap me-2"></i>Nilai</a>
                <a href="{{ route('dosen.datamahasiswa.index') }}" class="nav-link {{ request()->routeIs('dosen.datamahasiswa.*') ? 'active' : '' }}"><i class="fa fa-id-card me-2"></i>Data Mahasiswa</a>
                <a href="{{ route('dosen.bimbingan.indexdosen') }}" class="nav-link {{ request()->routeIs('dosen.bimbingan.*') ? 'active' : '' }}"><i class="fa fa-chalkboard-teacher me-2"></i>Bimbingan</a>
                <a href="{{ route('dosen.proposal.indexdosen') }}" class="nav-link {{ request()->routeIs('dosen.proposal.*') ? 'active' : '' }}"><i class="fa fa-file-alt me-2"></i>Proposal</a>
                <a href="{{ route('dosen.suratpengantar.indexdosen') }}" class="nav-link {{ request()->routeIs('dosen.suratpengantar.*') ? 'active' : '' }}"><i class="fa fa-envelope me-2"></i>Surat Pengantar</a>
                <a href="{{ route('dosen.pemberkasan.indexdosen') }}" class="nav-link {{ request()->routeIs('dosen.pemberkasan.*') ? 'active' : '' }}"><i class="fa fa-folder me-2"></i>Pemberkasan</a>
                <a href="{{ route('dosen.seminar.indexdosen') }}" class="nav-link {{ request()->routeIs('dosen.seminar.*') ? 'active' : '' }}"><i class="fa fa-calendar me-2"></i>Seminar</a>
                <a href="{{ route('dosen.penguji.indexdosen') }}" class="nav-link {{ request()->routeIs('dosen.penguji.*') ? 'active' : '' }}"><i class="fa fa-user-check me-2"></i>Penguji</a>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="col-10 d-flex flex-column">
            <!-- Header -->
            <div class="header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">@yield('header-title', 'Dashboard Dosen')</h5>
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fw-semibold">{{ Auth::user()->name }}</span> <br>
                        <small>Dosen</small>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit me-2"></i>Edit Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>

            <!-- Page-specific content -->
            <main class="container-fluid mt-4 flex-grow-1 px-4">
                @yield('content')
            </main>

            <!-- Footer -->
            <div class="footer">
                <small>&copy; 2025 SIPRAKELRA - Sistem Informasi PKL | Politala</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>