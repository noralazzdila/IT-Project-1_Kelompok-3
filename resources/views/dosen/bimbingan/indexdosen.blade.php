@extends('dosen.layouts.app')

@section('title', 'Kelola Data Bimbingan PKL')

@section('header-title', 'Manajemen Bimbingan PKL')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Bimbingan</li>
    </ol>
</nav>

<div class="card rounded-3 shadow-sm">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <a href="{{ route('dosen.bimbingan.createdosen') }}" class="btn btn-success">
                <i class="fa-solid fa-plus me-2"></i> Tambah Bimbingan
            </a>
            <form action="{{ route('dosen.bimbingan.indexdosen') }}" method="GET" class="d-flex flex-wrap gap-2">
                <select name="status" class="form-select" onchange="this.form.submit()" style="width: auto;">
                    <option value="Semua" {{ request('status', 'Semua') == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Revisi" {{ request('status') == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                </select>
                <div class="input-group" style="width: auto;">
                    <input type="text" name="search" class="form-control" placeholder="Cari Mahasiswa/Dosen..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Dosen Pembimbing</th>
                        <th>Tanggal</th>
                        <th>Topik</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bimbingans as $index => $bimbingan)
                        <tr>
                            <td class="text-center">{{ $bimbingans->firstItem() + $index }}</td>
                            <td>{{ $bimbingan->mahasiswa_nama }}</td>
                            <td>{{ $bimbingan->nim }}</td>
                            <td>{{ $bimbingan->dosen_pembimbing }}</td>
                            <td>{{ \Carbon\Carbon::parse($bimbingan->tanggal_bimbingan)->isoFormat('D MMM Y') }}</td>
                            <td>{{ $bimbingan->topik_bimbingan }}</td>
                            <td class="text-center">
                                @if($bimbingan->status == 'Disetujui')
                                    <span class="badge bg-success">{{ $bimbingan->status }}</span>
                                @elseif($bimbingan->status == 'Revisi')
                                    <span class="badge bg-warning text-dark">{{ $bimbingan->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $bimbingan->status }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form onsubmit="return confirm('Apakah Anda Yakin ingin menghapus data ini?');" action="{{ route('dosen.bimbingan.destroy', $bimbingan->id) }}" method="POST">
                                    <a href="{{ route('dosen.bimbingan.showdosen', $bimbingan->id) }}" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('dosen.bimbingan.editdosen', $bimbingan->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <div class="alert alert-warning mb-0">
                                    Data Bimbingan tidak ditemukan.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
           {{ $bimbingans->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- Custom breadcrumb is already in app.blade.php, no need here unless specific to this page --}}
@endpush

@push('scripts')
{{-- No specific scripts for this page --}}
@endpush