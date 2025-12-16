@extends('mahasiswa.layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="text-primary mb-4">Profil Saya</h3>
    
    <div class="card p-4 shadow-lg frosted-card">
        <div class="d-flex align-items-center mb-4">
            <img src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : asset('images/user-fill.png') }}" 
                 alt="Foto Profil" class="rounded-circle shadow-sm" width="100" height="100">
            <div class="ms-3">
                <h5 class="fw-bold">{{ $user->name }}</h5>
                <p class="text-muted mb-0"><i class="bi bi-envelope-fill me-2"></i>{{ $user->email }}</p>
            </div>
        </div>

        <hr>

        <div class="row text-center mt-3">
            <div class="col-md-6 mb-3">
                <div class="info-box p-3 shadow-sm rounded frosted-input">
                    <i class="bi bi-person-badge-fill fs-3 text-primary mb-2"></i>
                    <h6 class="mb-0">Role</h6>
                    <p class="mb-0">{{ $user->role ?? 'Mahasiswa' }}</p>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="info-box p-3 shadow-sm rounded frosted-input">
                    <i class="bi bi-building fs-3 text-primary mb-2"></i>
                    <h6 class="mb-0">Departemen</h6>
                    <p class="mb-0">{{ $user->department ?? '-' }}</p>
                </div>
            </div>
        </div>
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

/* Info box style */
.frosted-input {
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(6px);
    border-radius: 12px;
    border: 1px solid rgba(0,64,128,0.2);
    padding: 20px 10px;
}

.info-box i {
    display: block;
}

/* Text styling */
.frosted-card h5, .info-box h6 {
    color: #004080;
}

.frosted-card p {
    color: #333;
}
</style>
@endsection
