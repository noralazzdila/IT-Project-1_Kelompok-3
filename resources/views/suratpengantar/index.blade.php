@extends('layouts.app')

@section('title', 'Manajemen Surat Pengantar PKL')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Surat Pengantar</li>
    </ol>
</nav>

<div class="card shadow-sm rounded-3">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Permohonan Surat Pengantar</h5>
         <a href="{{ route('suratpengantar.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus-circle me-2"></i> Tambah Surat Pengantar
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('suratpengantar.index') }}" method="GET" class="mb-4">
            <div class="row g-2 align-items-center">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau tempat PKL..." value="{{ request('search') }}">
                </div>
                <div class="col-md-5">
                    <select name="status" class="form-select">
                        <option value="">Filter Status</option>
                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Cari</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" style="width: 5%;">No</th>
                        <th style="width: 25%;">Nama Mahasiswa</th>
                        <th style="width: 30%;">Tempat PKL</th>
                        <th class="text-center" style="width: 15%;"> Surat Pengantar</th>
                        <th class="text-center" style="width: 10%;">Status</th>
                        <th class="text-center" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suratPengantars as $index => $surat)
                    <tr>
                        <td class="text-center">{{ $suratPengantars->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $surat->nama_mahasiswa }}</strong><br>
                            <small class="text-muted">{{ $surat->nim }} | {{ $surat->prodi }}</small>
                        </td>
                        <td>
                            <strong>{{ $surat->tempat_pkl }}</strong><br>
                            <small class="text-muted">{{ $surat->alamat_perusahaan }}</small>
                        </td>
                        <td class="text-center">
                            @if ($surat->file_surat && Illuminate\Support\Facades\Storage::disk('public')->exists($surat->file_surat))
                                <a href="{{ Illuminate\Support\Facades\Storage::disk('public')->url($surat->file_surat) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-file-pdf me-1"></i> Lihat File
                                </a>
                            @else
                                <span class="badge bg-secondary">Belum Ada</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @php
                                $badgeClass = match($surat->status) {
                                    'Menunggu' => 'bg-warning text-dark',
                                    'Diproses' => 'bg-primary',
                                    'Selesai' => 'bg-success',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $surat->status }}</span>
                        </td>
                        <td class="text-center">
                            <form onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?');" action="{{ route('suratpengantar.destroy', $surat->id) }}" method="POST">
                                <a href="{{ route('suratpengantar.show', $surat->id) }}" class="btn btn-info btn-sm text-white" title="Lihat"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('suratpengantar.edit', $surat->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="alert alert-warning mb-0">
                                Data permohonan surat pengantar tidak ditemukan.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-3">
            {{ $suratPengantars->links() }}
        </div>
    </div>
</div>
@endsection