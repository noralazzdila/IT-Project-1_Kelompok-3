@extends('layouts.app')

@section('content')
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
                        <div class="modul-card text-center" onclick="showRoles('sim-akademik')">
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

<style>
    /* Header biru */
    .header-custom {
        background: #004080 url("{{ asset('images/pattern.png') }}") repeat;
    }

    /* Modul card */
    .modul-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        background-color: #fff;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .modul-card:hover {
        background-color: #f8f9fa;
        transform: translateY(-3px);
    }

    /* Role card */
    .role-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 15px 20px;
        background: #fff;
        margin-bottom: 15px;
        transition: all 0.2s ease-in-out;
    }
    .role-card:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
    }
    .role-title {
        font-weight: 600;
        color: #0056b3;
        margin-bottom: 3px;
    }
    .role-sub {
        font-size: 0.9rem;
        color: #666;
    }
</style>

<script>
    function showRoles(module) {
        let roleContainer = document.getElementById('role-container');

        if (module === 'sim-akademik') {
            roleContainer.innerHTML = `
                <h5 class="fw-bold mb-3">Daftar Role - SIM PKL</h5>

    
                 <div class="role-card" onclick="window.location='{{ route('dosen.dashboard') }}'"style="cursor:pointer;">
                    <div class="role-title">Dosen</div>
                    <div class="role-sub">Teknologi Informasi</div>
                </div>
                
        
               <div class="role-card" onclick="window.location='{{ route('koor.dashboard') }}'"style="cursor:pointer;">
                            <div class="role-title">Koordinator PKL</div>
                            <pdiv class="role-sub">Teknologi Informasi</div>
                    </div>
    
             
                 <div class="role-card" onclick="window.location='/staf'"style="cursor:pointer;">
                    <div class="role-title">Staf</div>
                    <div class="role-sub">Teknologi Informasi</div>
                </div>

            
                 <div class="role-card" onclick="window.location='{{ route('koorprodi.index') }}'"style="cursor:pointer;">
                    <div class="role-title">Koordinator Prodi</div>
                    <div class="role-sub">Teknologi Informasi</div>
                </div>

                <div class="role-card" onclick="window.location='{{ route('dashboard.mahasiswa') }}'"style="cursor:pointer;">
                    <div class="role-title">Mahasiswa</div>
                    <div class="role-sub">Teknologi Informasi</div>
                </div>
            `;
        }
    }
</script>
@endsection
