@extends('koorprodi.layouts.app')

@section('title', 'Kelola Proposal - Koordinator Prodi')

@section('header-title', 'Kelola Proposal')

@section('content')
<div class="container mt-4 flex-grow-1">
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <h6 class="fw-bold">Daftar Proposal</h6>
        <a href="{{ route('koorprodi.proposal.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Proposal
        </a>
    </div>

    <div class="card shadow-sm p-3">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>Judul Proposal</th>
                    <th>Pembimbing</th>
                    <th>Tempat PKL</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proposals as $i => $proposal)
                <tr>
                    <td>{{ $proposals->firstItem() + $i }}</td>
                    <td>
                        <strong>{{ $proposal->nama_mahasiswa }}</strong><br>
                        <small class="text-muted">{{ $proposal->nim }}</small>
                    </td>
                    <td>{{ Str::limit($proposal->judul_proposal, 35) }}</td>
                    <td>{{ $proposal->pembimbing }}</td>
                    <td>{{ $proposal->tempat_pkl }}</td>
                    <td>
                        @php
                            $badgeClass = '';
                            if ($proposal->status == 'Menunggu') $badgeClass = 'bg-warning text-dark';
                            elseif ($proposal->status == 'Disetujui') $badgeClass = 'bg-success';
                            elseif ($proposal->status == 'Ditolak') $badgeClass = 'bg-danger';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $proposal->status }}</span>
                    </td>
                    <td>
                        <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" action="{{ route('koorprodi.proposal.destroy', $proposal->id) }}" method="POST">
                            <a href="{{ route('koorprodi.proposal.show', $proposal->id) }}" class="btn btn-info btn-sm text-white" title="Lihat"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('koorprodi.proposal.edit', $proposal->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data proposal.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $proposals->links() }}
        </div>
    </div>
</div>
@endsection
