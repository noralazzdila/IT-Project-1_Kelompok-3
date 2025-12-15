@extends('koorprodi.layouts.app')

@section('title', 'Kelola Data Dosen')
@section('header-title', 'Manajemen Data Dosen')

@section('content')
<main class="container-fluid mt-4 flex-grow-1">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('koorprodi.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kelola Dosen</li>
        </ol>
    </nav>
    <div class="card rounded-3 shadow-sm">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <a href="{{ route('koorprodi.datadosen.create') }}" class="btn btn-success">
                    <i class="fa-solid fa-plus me-2"></i> Tambah Dosen
                </a>
                <form action="{{ route('koorprodi.datadosen.index') }}" method="GET" class="d-flex" style="max-width: 300px;">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari Nama atau NIP..." value="{{ request('search') }}">
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
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dosens as $index => $dosen)
                            <tr>
                                <td class="text-center">{{ $dosens->firstItem() + $index }}</td>
                                <td>{{ $dosen->nip }}</td>
                                <td>{{ $dosen->nama }}</td>
                                <td>{{ $dosen->jabatan }}</td>
                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" action="{{ route('koorprodi.datadosen.destroy', $dosen->id) }}" method="POST">
                                        <a href="{{ route('koorprodi.datadosen.show', $dosen->id) }}" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                                        <a href="{{ route('koorprodi.datadosen.edit', $dosen->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <div class="alert alert-warning mb-0">
                                        Data Dosen tidak ditemukan atau belum tersedia.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             <div class="mt-3">
                {{ $dosens->links() }}
            </div>
        </div>
    </div>
</main>
@endsection
