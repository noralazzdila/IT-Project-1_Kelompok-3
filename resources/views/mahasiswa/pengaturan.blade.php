@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary animate__fadeInDown">Pengaturan Akun</h3>
        <a href="{{ route('dashboard.mahasiswa') }}" class="btn btn-outline-primary shadow-sm animate__fadeInDown">
            <i class="bi bi-arrow-left-circle me-2"></i>Kembali ke Dashboard
        </a>
    </div>

    <div class="card p-4 shadow-lg frosted-card animate__fadeInUp">
        <ul class="nav nav-tabs mb-4 frosted-tabs" id="settingsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profil-tab" data-bs-toggle="tab" data-bs-target="#profil" type="button" role="tab">Profil</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">Ubah Password</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="preferensi-tab" data-bs-toggle="tab" data-bs-target="#preferensi" type="button" role="tab">Preferensi</button>
            </li>
        </ul>

        <div class="tab-content animate__fadeIn" id="settingsTabContent">
            <!-- Profil Tab -->
            <div class="tab-pane fade show active" id="profil" role="tabpanel">
                <form action="{{ route('mahasiswa.profil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control frosted-input" value="{{ $user->name }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control frosted-input" value="{{ $user->email }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="phone" class="form-control frosted-input" value="{{ $user->phone ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto Profil</label>
                        <input type="file" name="profile_photo" class="form-control frosted-input">
                        @if($user->profile_photo)
                        <img src="{{ route('user.photo', $user) }}" alt="Profil" class="mt-2 rounded-circle shadow-sm" style="width:100px; height:100px;">
                        @endif
                    </div>
                    <button type="submit" class="btn frosted-btn">Simpan Perubahan</button>
                </form>
            </div>

            <!-- Password Tab -->
            <div class="tab-pane fade" id="password" role="tabpanel">
                <form action="{{ route('mahasiswa.profil.update_password') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <input type="password" name="current_password" class="form-control frosted-input">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="new_password" class="form-control frosted-input">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control frosted-input">
                    </div>
                    <button type="submit" class="btn frosted-btn">Ubah Password</button>
                </form>
            </div>

            <!-- Preferensi Tab -->
            <div class="tab-pane fade" id="preferensi" role="tabpanel">
                <form action="{{ route('mahasiswa.preferensi.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tema Aplikasi</label>
                        <select name="theme" class="form-select frosted-input">
                            <option value="light" {{ $user->theme == 'light' ? 'selected' : '' }}>Terang</option>
                            <option value="dark" {{ $user->theme == 'dark' ? 'selected' : '' }}>Gelap</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notifikasi</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="notif_email" {{ $user->notif_email ? 'checked' : '' }}>
                            <label class="form-check-label">Email</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="notif_sms" {{ $user->notif_sms ? 'checked' : '' }}>
                            <label class="form-check-label">SMS</label>
                        </div>
                    </div>
                    <button type="submit" class="btn frosted-btn">Simpan Preferensi</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .frosted-card {
        background: rgba(243, 244, 245, 0.36);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        border: 1px solid rgba(0,64,128,0.3);
        color: #004080;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s forwards;
    }

    .frosted-tabs .nav-link.active {
        background-color: #004080;
        color: #fff !important;
        border-radius: 12px 12px 0 0;
        font-weight: 600;
    }
    .frosted-tabs .nav-link {
        color: #004080;
        font-weight: 500;
    }

    .frosted-input {
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(0,64,128,0.5);
        border-radius: 12px;
        color: #004080;
    }
    .frosted-input:focus {
        box-shadow: 0 0 8px rgba(0,64,128,0.6);
        border-color: #004080;
        background: rgba(255,255,255,0.3);
    }

    .frosted-btn {
        background-color: #004080;
        border-radius: 12px;
        padding: 10px 24px;
        font-weight: 600;
        color: #fff;
        transition: all 0.3s ease;
    }
    .frosted-btn:hover {
        background-color: #003366;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }
    .tab-pane.fade.show {
        animation: fadeIn 0.5s;
    }
</style>

<script>
    const tabs = document.querySelectorAll('button[data-bs-toggle="tab"]');
    tabs.forEach(tab => {
        tab.addEventListener('shown.bs.tab', function (e) {
            const target = document.querySelector(e.target.getAttribute('data-bs-target'));
            target.classList.add('animate__fadeIn');
            setTimeout(() => target.classList.remove('animate__fadeIn'), 500);
        });
    });
</script>
@endsection
