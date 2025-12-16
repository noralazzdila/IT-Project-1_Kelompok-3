@extends('koor-pkl.layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container mt-5">
    <h3 class="text-primary mb-4">Profil Saya</h3>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="card p-4 shadow-lg frosted-card">
        <form action="{{ route('koor.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-center mb-4">
                <img src="{{ $user->profile_photo ? asset('profile_photos/' . $user->profile_photo) : asset('images/user-fill.png') }}" 
                     alt="Foto Profil" class="rounded-circle shadow-sm" width="100" height="100">
                <div class="ms-3">
                    <h5 class="fw-bold">{{ $user->name }}</h5>
                    <p class="text-muted mb-0"><i class="bi bi-envelope-fill me-2"></i>{{ $user->email }}</p>
                    <label for="profile_photo" class="btn btn-sm btn-primary mt-2">Ubah Foto</label>
                    <input type="file" name="profile_photo" id="profile_photo" class="d-none">
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Telepon</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
</style>
@endsection
