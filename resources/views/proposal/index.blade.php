@extends('layouts.app')

@section('title', 'Manajemen Proposal PKL')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('koor.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Proposal</li>
    </ol>
</nav>

<div class="card shadow-sm rounded-3">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Pengajuan Proposal PKL</h5>
        <a href="{{ route('proposal.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus-circle me-2"></i> Tambah Proposal
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('proposal.index') }}" method="GET" class="mb-4">
            <div class="row g-2 align-items-center">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama mahasiswa atau judul..." value="{{ request('search') }}">
                </div>
                <div class="col-md-5">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
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
                        <th class="text-center">No</th>
                        <th>Mahasiswa</th>
                        <th>Judul Proposal</th>
                        <th>Pembimbing</th>
                        <th>Tempat PKL</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($proposals as $index => $proposal)
                    <tr>
                        <td class="text-center">{{ $proposals->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $proposal->nama_mahasiswa }}</strong><br>
                            <small class="text-muted">{{ $proposal->nim }}</small>
                        </td>
                        <td>{{ Str::limit($proposal->judul_proposal, 35) }}</td>
                        <td>{{ $proposal->dosen->nama ?? 'N/A' }}</td>
                        <td>{{ $proposal->tempat_pkl }}</td>
                        <td class="text-center">
                            @php
                                $badgeClass = '';
                                if ($proposal->status == 'Menunggu') {
                                    $badgeClass = 'bg-warning text-dark';
                                } elseif ($proposal->status == 'Disetujui') {
                                    $badgeClass = 'bg-success text-white';
                                } elseif ($proposal->status == 'Ditolak') {
                                    $badgeClass = 'bg-danger text-white';
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $proposal->status }}</span>
                        </td>
                        <td class="text-center">
                            <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" action="{{ route('proposal.destroy', $proposal->id) }}" method="POST">
                                <a href="{{ route('proposal.show', $proposal->id) }}" class="btn btn-info btn-sm text-white" title="Lihat"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('proposal.edit', $proposal->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            <div class="alert alert-warning mb-0">
                                Data proposal tidak ditemukan atau belum tersedia.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-3">
            {{ $proposals->links() }}
        </div>
    </div>
</div>
@endsection