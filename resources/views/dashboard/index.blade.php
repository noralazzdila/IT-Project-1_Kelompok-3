<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Pengelolaan PKL</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (opsional untuk icon profil/logout) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body class="bg-light" data-user="{{ json_encode($user) }}">

  
<div class="container-fluid p-0">
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center px-4 py-3 header-custom text-white">
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/Logo_Politala.png') }}" alt="Logo" width="60" class="me-3">
            <div>
                <h5 class="mb-0 fw-bold">Sistem Informasi Pengelolaan PKL</h5>
                <small>POLITEKNIK NEGERI TANAH LAUT</small>
            </div>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm me-2">
                <i class="bi bi-person"></i> Halaman Profil
            </a>
            <a href="{{ route('logout') }}" class="btn btn-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </a>
        </div>
    </div>

    <!-- BODY -->
    <div class="container-fluid px-4 py-4">
        <div class="row">
            <!-- Kiri: Daftar Modul -->
            <div class="col-md-6 mb-4">
                <h5 class="fw-bold mb-3">Daftar Modul</h5>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="modul-card text-center">
                            <img src="{{ asset('images/Logo ti.png') }}" width="60" class="mx-auto mb-3">
                            <h6 class="fw-semibold">SIM PKL</h6>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="modul-card text-center">
                            <a href="https://edlink.id/" target="_blank" class="text-decoration-none text-dark">
                            <img src="{{ asset('images/Edlink.png') }}" width="60" class="mx-auto mb-3">
                            <h6 class="fw-semibold">Edlink</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="modul-card text-center">
                            <a href="https://sipadu.politala.ac.id/gate/login" target="_blank" class="text-decoration-none text-dark">
                            <img src="{{ asset('images/sipadu.png') }}" width="60" class="mx-auto mb-3">
                            <h6 class="fw-semibold">SIPadu</h6>
                            </a>
                        </div>
                    </div>
                    <div class="col-6">
                    <div class="modul-card text-center">
                        <a href="https://politala.ac.id/" target="_blank" class="text-decoration-none text-dark">
                            <img src="{{ asset('images/Logo_Politala.png') }}" width="60" class="mx-auto mb-3">
                            <h6 class="fw-semibold">POLITALA</h6>
                        </a>
                    </div>
                </div>
                </div>
            </div>

            <!-- Kanan: Daftar Role -->
            <div class="col-md-6" id="role-container">
                <h5 class="fw-bold mb-3">Daftar Role</h5>
                <div class="text-muted">Pilih modul di sebelah kiri untuk melihat role.</div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    var routes = {
        dashboardMahasiswa: "{{ route('dashboard.mahasiswa') }}",
        koorDashboard: "{{ route('koor.dashboard') }}",
        dosenDashboard: "{{ route('dosen.dashboard') }}",
        stafIndex: "{{ route('staf.index') }}",
        koorprodiIndex: "{{ route('koorprodi.index') }}"
    };
</script>
<script src="{{ asset('js/dashboard.js') }}"></script>

</body>
</html>