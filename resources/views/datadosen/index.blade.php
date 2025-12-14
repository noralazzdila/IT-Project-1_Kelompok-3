@extends('layouts.app')

@section('title', 'Manajemen Data Dosen')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('koor.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Dosen</li>
    </ol>
</nav>
<div class="card rounded-3 shadow-sm">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <a href="{{ route('datadosen.create') }}" class="btn btn-success">
                <i class="fa-solid fa-plus me-2"></i> Tambah Dosen
            </a>
            <form action="{{ route('datadosen.index') }}" method="GET" class="w-100">
                  <div class="input-group">
                     <span class="input-group-text bg-light border-end-0">
                        <i class="fa fa-search text-muted"></i>
                    </span>
                 <input 
                      type="text" 
                      name="search" 
                      class="form-control border-start-0" 
                      placeholder="Cari Dosen berdasarkan NIP dan nama..." 
                      value="{{ request('search') }}">
                    @if(request('search'))
                  <a href="{{ route('datamahasiswa.index') }}" class="input-group-text bg-light text-danger" title="Hapus pencarian">
                     <i class="fa fa-times"></i>  </a>@endif
                        <button type="submit" class="btn btn-primary">Cari</button>
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
                                <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" action="{{ route('datadosen.destroy', $dosen->id) }}" method="POST">
                                    <a href="{{ route('datadosen.show', $dosen->id) }}" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('datadosen.edit', $dosen->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil"></i></a>
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
@endsection