@extends('staf.layouts.app')

@section('title', 'Kelola Data Dosen - Staf')

@section('header-title', 'Kelola Data Dosen')

@section('content')
<div class="container mt-4 flex-grow-1">
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <h6 class="fw-bold">Daftar Dosen</h6>
        <a href="{{ route('staf.datadosen.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Dosen
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('staf.datadosen.index') }}" method="GET" class="d-flex align-items-center">
                <div class="input-group">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control border-end-0" 
                        placeholder="Cari dosen berdasarkan Nama atau NIP..." 
                        value="{{ request('search') }}"
                    >
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Program Studi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dosens as $i => $dosen)
                    <tr>
                        <td>{{ $dosens->firstItem() + $i }}</td>
                        <td>{{ $dosen->nip }}</td>
                        <td>{{ $dosen->nama }}</td>
                        <td>{{ $dosen->email }}</td>
                        <td>{{ $dosen->prodi }}</td>
                        <td>
                            <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" action="{{ route('staf.datadosen.destroy', $dosen->id) }}" method="POST">
                                <a href="{{ route('staf.datadosen.show', $dosen->id) }}" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('staf.datadosen.edit', $dosen->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil"></i></a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Data Dosen tidak ditemukan.
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
@endsection
