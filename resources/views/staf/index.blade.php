@extends('staf.layouts.app')

@section('title', 'Dashboard Staf')

@section('header-title', 'Dashboard Staf')

@section('content')
<div class="row g-3">
    <div class="col-md-3">
        <a href="{{ route('staf.datamahasiswa.index') }}" class="text-decoration-none text-dark">
            <div class="card card-dashboard text-center p-3 shadow-sm">
                <i class="fa fa-users mb-2"></i>
                <h6>Total Mahasiswa</h6>
                <h4>{{ $totalMahasiswa }}</h4>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('staf.datadosen.index') }}" class="text-decoration-none text-dark">
            <div class="card card-dashboard text-center p-3 shadow-sm">
                <i class="fa fa-user-tie mb-2"></i>
                <h6>Total Dosen</h6>
                <h4>{{ $totalDosen }}</h4>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('staf.tempatpkl.index') }}" class="text-decoration-none text-dark">
            <div class="card card-dashboard text-center p-3 shadow-sm">
                <i class="fa fa-building mb-2"></i>
                <h6>Total Tempat PKL</h6>
                <h4>{{ $totalTempatPkl }}</h4>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('staf.seminar.index') }}" class="text-decoration-none text-dark">
            <div class="card card-dashboard text-center p-3 shadow-sm">
                <i class="fa fa-calendar-check mb-2"></i>
                <h6>Total Seminar</h6>
                <h4>{{ $totalSeminar }}</h4>
            </div>
        </a>
    </div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-body">
        <h5 class="card-title">Selamat Datang, Staf!</h5>
        <p class="card-text">Ini adalah halaman dashboard Anda. Silakan gunakan menu di samping untuk mengelola data yang terkait dengan Praktik Kerja Lapangan (PKL).</p>
    </div>
</div>
@endsection

@push('styles')
<style>
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
</style>
@endpush
