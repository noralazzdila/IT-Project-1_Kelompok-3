@extends('dosen.layouts.app')

@section('title', 'Kelola Pemberkasan')

@section('header-title', 'Manajemen Pemberkasan')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Pemberkasan</li>
    </ol>
</nav>

<div class="card rounded-3 shadow-sm">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <a href="{{ route('dosen.pemberkasan.createdosen') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-2"></i> Tambah Data Pemberkasan
            </a>
            <form action="{{ route('dosen.pemberkasan.indexdosen') }}" method="GET" class="d-flex flex-wrap gap-2">
                 <select name="status" class="form-select" onchange="this.form.submit()" style="width: auto;">
                    <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="lengkap" {{ request('status') == 'lengkap' ? 'selected' : '' }}>Lengkap</option>
                    <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Lengkap</option>
                </select>
                <div class="input-group" style="width: auto;">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama/NIM Mahasiswa..." value="{{ request('search') }}">
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
                        <th>Tanggal Verifikasi</th>
                        <th class="text-center">Status Kelengkapan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemberkasans as $index => $pemberkasan)
                        <tr>
                            <td class="text-center">{{ $pemberkasans->firstItem() + $index }}</td>
                            <td>{{ $pemberkasan->mahasiswa->nama ?? 'N/A' }}</td>
                            <td>{{ $pemberkasan->mahasiswa->nim ?? 'N/A' }}</td>
                            <td>{{ $pemberkasan->tanggal_verifikasi ? \Carbon\Carbon::parse($pemberkasan->tanggal_verifikasi)->isoFormat('D MMM Y') : 'Belum Diverifikasi' }}</td>
                            <td class="text-center">
                                @if($pemberkasan->is_lengkap)
                                    <span class="badge bg-success">Lengkap</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Lengkap</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form onsubmit="return confirm('Apakah Anda Yakin ingin menghapus data ini?');" action="{{ route('dosen.pemberkasan.destroy', $pemberkasan->id) }}" method="POST">
                                    <a href="{{ route('dosen.pemberkasan.showdosen', $pemberkasan->id) }}" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('dosen.pemberkasan.editdosen', $pemberkasan->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="alert alert-warning mb-0">
                                    Data Pemberkasan tidak ditemukan.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
           {{ $pemberkasans->links() }}
        </div>
    </div>
</div>
@endsection
