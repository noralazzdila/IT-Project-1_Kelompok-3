@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary animate__fadeInDown">Daftar Tempat PKL</h3>
        <a href="{{ route('dashboard.mahasiswa') }}" class="btn btn-outline-primary shadow-sm animate__fadeInDown">
            <i class="bi bi-arrow-left-circle me-2"></i>Kembali ke Dashboard
        </a>
    </div>

    <div class="card p-4 shadow-lg frosted-card animate__fadeInUp">
        <div class="row g-4">
            @foreach($tempatPKL as $tempat)
            <div class="col-md-6">
                <div class="card p-3 frosted-card hover-scale">
                    <div class="d-flex align-items-center">
                        <img src="{{ $tempat->logo_url ?? 'https://placehold.co/100x100?text=Logo' }}" 
                             alt="{{ $tempat->nama }}" class="rounded shadow-sm me-3" style="width:60px; height:60px; object-fit:cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $tempat->nama }}</h6>
                            <p class="mb-0 text-muted" style="font-size:0.85rem;">
                                <i class="bi bi-geo-alt-fill me-1"></i>{{ $tempat->alamat }}
                            </p>
                        </div>
                        <a href="#" class="btn btn-sm frosted-btn ms-3">Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($tempatPKL->count() == 0)
        <div class="text-center text-muted mt-4">
            Tidak ada tempat PKL tersedia saat ini.
        </div>
        @endif
    </div>
</div>

<style>
    .frosted-card {
        background: rgba(243, 244, 245, 0.36);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        border: 1px solid rgba(0,64,128,0.3);
        color: #004080;
        transition: all 0.3s ease;
    }
    .frosted-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .frosted-btn {
        background-color: #004080;
        border-radius: 12px;
        padding: 6px 18px;
        font-weight: 600;
        color: #fff;
        transition: all 0.3s ease;
    }
    .frosted-btn:hover {
        background-color: #003366;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .hover-scale {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-scale:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
</style>
@endsection
