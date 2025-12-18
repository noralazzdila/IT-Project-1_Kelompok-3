@extends('mahasiswa.layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="text-primary mb-4">Profil Saya</h3>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card p-4 shadow-lg frosted-card">
        <form action="{{ route('mahasiswa.profil') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="d-flex align-items-center mb-4">
                <label for="profile_photo_input" style="cursor: pointer;">
                    <img src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : asset('images/user-fill.png') }}" 
                         alt="Foto Profil" class="rounded-circle shadow-sm" width="100" height="100" id="profile_photo_preview">
                </label>
                <input type="file" name="profile_photo" id="profile_photo_input" class="d-none" accept="image/*">
                <div class="ms-3">
                    <h5 class="fw-bold">{{ $user->name }}</h5>
                    <p class="text-muted mb-0"><i class="bi bi-envelope-fill me-2"></i>{{ $user->email }}</p>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim', optional($user->mahasiswa)->nim) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">No. Telepon</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                </div>
                {{-- Static display for role and departemen (if applicable) --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control" value="{{ $user->role ?? 'Mahasiswa' }}" disabled>
                </div>
                {{-- Assuming department might come from Mahasiswa or User, display static for now --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Prodi</label>
                    <input type="text" class="form-control" value="{{ optional($user->mahasiswa)->prodi ?? '-' }}" disabled>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('mahasiswa.pengaturan') }}" class="btn btn-secondary ms-2">Pengaturan Akun</a>
            </div>
        </form>
    </div>

    {{-- Password Update Form --}}
    <div class="card p-4 shadow-lg frosted-card mt-5">
        <h5 class="fw-bold text-primary mb-3">Ubah Password</h5>
        <form action="{{ route('mahasiswa.profil.update_password') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="current_password" class="form-label">Password Lama</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary">Ubah Password</button>
        </form>
    </div>
</div>

<style>
/* Frosted glass effect */
.frosted-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 20px;
    border: 1px solid rgba(0,0,0,0.1);
    color: #004080;
}

/* Info box style (now used for inputs and static info) */
.frosted-input {
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(6px);
    border-radius: 12px;
    border: 1px solid rgba(0,64,128,0.2);
    padding: 20px 10px; /* Adjust padding as needed for inputs */
}

/* Text styling */
.frosted-card h5, .info-box h6 {
    color: #004080;
}

.frosted-card p {
    color: #333;
}
</style>

<script>
document.getElementById('profile_photo_input').addEventListener('change', function(event) {
    if (event.target.files && event.target.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile_photo_preview').src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
});
</script>
@endsection
