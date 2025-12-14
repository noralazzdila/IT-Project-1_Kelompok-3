@extends('dosen.layouts.app')

@section('title', 'Kelola Data Mahasiswa PKL')

@section('header-title', 'Manajemen Data Mahasiswa')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Mahasiswa</li>
    </ol>
</nav>
<div class="card rounded-3 shadow-sm">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <a href="{{ route('dosen.datamahasiswa.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-2"></i> Tambah Mahasiswa
            </a>
            <form action="{{ route('dosen.datamahasiswa.index') }}" method="GET" class="d-flex" style="max-width: 300px;">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari Nama atau NIM..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
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
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th>Kelas</th>
                        <th>Dosen Pembimbing</th>
                        <th>Tempat PKL</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswa as $index => $mhs)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $mhs->nim }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->prodi }}</td>
                            <td>{{ $mhs->kelas }}</td>
                            <td>{{ $mhs->dosen_pembimbing }}</td>
                            <td>{{ $mhs->tempat_pkl }}</td>
                            <td class="text-center"><span class="badge bg-info">{{ $mhs->status_pkl }}</span></td>
                            <td class="text-center">
                                <form action="{{ route('dosen.datamahasiswa.destroy', $mhs->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('dosen.datamahasiswa.show', $mhs->id) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fa-solid fa-eye"></i></a>
                                        <a href="{{ route('dosen.datamahasiswa.edit', $mhs->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fa-solid fa-pencil"></i></a>
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="fa-solid fa-trash"></i></button>
                                            </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                <div class="alert alert-warning mb-0">
                                    Data Mahasiswa tidak ditemukan atau belum tersedia.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $mahasiswa->links() }}
        </div>
    </div>
</div>
@endsection