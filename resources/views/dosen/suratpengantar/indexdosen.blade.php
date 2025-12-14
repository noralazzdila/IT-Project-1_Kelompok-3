@extends('dosen.layouts.app')

@section('title', 'Kelola Surat Pengantar')

@section('header-title', 'Manajemen Surat Pengantar')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Surat Pengantar</li>
    </ol>
</nav>

<div class="card rounded-3 shadow-sm">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <a href="{{ route('dosen.suratpengantar.createdosen') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-2"></i> Tambah Surat Pengantar
            </a>
            <form action="{{ route('dosen.suratpengantar.indexdosen') }}" method="GET" class="d-flex flex-wrap gap-2">
                <select name="status" class="form-select" onchange="this.form.submit()" style="width: auto;">
                    <option value="Semua" {{ request('status', 'Semua') == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="Revisi" {{ request('status') == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                </select>
                <div class="input-group" style="width: auto;">
                    <input type="text" name="search" class="form-control" placeholder="Cari Mahasiswa/Tempat PKL..." value="{{ request('search') }}">
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
                        <th>Tempat PKL</th>
                        <th>Prodi</th>
                        <th>Tanggal</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suratpengantars as $index => $surat)
                        <tr>
                            <td class="text-center">{{ $suratpengantars->firstItem() + $index }}</td>
                            <td>{{ $surat->nama_mahasiswa }}</td>
                            <td>{{ $surat->nim }}</td>
                            <td>{{ $surat->tempat_pkl }}</td>
                            <td>{{ $surat->prodi }}</td>
                            <td>{{ \Carbon\Carbon::parse($surat->tanggal_pengajuan)->isoFormat('D MMM Y') }}</td>
                            <td class="text-center">
                                @if($surat->status == 'Diterima')
                                    <span class="badge bg-success">{{ $surat->status }}</span>
                                @elseif($surat->status == 'Ditolak')
                                    <span class="badge bg-danger">{{ $surat->status }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ $surat->status }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form onsubmit="return confirm('Apakah Anda Yakin ingin menghapus data ini?');" action="{{ route('dosen.suratpengantar.destroy', $surat->id) }}" method="POST">
                                    <a href="{{ route('dosen.suratpengantar.showdosen', $surat->id) }}" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('dosen.suratpengantar.editdosen', $surat->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil"></i></a>
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
                                    Data Surat Pengantar tidak ditemukan.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
           {{ $suratpengantars->links() }}
        </div>
    </div>
</div>
@endsection
