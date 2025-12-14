@extends('layouts.app')

@section('title', 'Manajemen Data Mahasiswa')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('koor.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Mahasiswa</li>
    </ol>
</nav>
<div class="card rounded-3 shadow-sm">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <a href="{{ route('datamahasiswa.create') }}" class="btn btn-success">
                <i class="fa-solid fa-plus me-2"></i> Tambah Mahasiswa
            </a>
            <form action="{{ route('datamahasiswa.index') }}" method="GET" class="w-100">
                  <div class="input-group">
                     <span class="input-group-text bg-light border-end-0">
                        <i class="fa fa-search text-muted"></i>
                    </span>
                 <input 
                      type="text" 
                      name="search" 
                      class="form-control border-start-0" 
                      placeholder="Cari mahasiswa berdasarkan NIM, nama, prodi, atau kelas..." 
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
                    @forelse ($mahasiswas as $index => $mhs)
                        <tr>
                            <td class="text-center">{{ $mahasiswas->firstItem() + $index }}</td>
                            <td>{{ $mhs->nim }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->prodi }}</td>
                            <td>{{ $mhs->kelas }}</td>
                            <td>{{ $mhs->dosen_pembimbing }}</td>
                            <td>{{ $mhs->tempat_pkl }}</td>
                            <td class="text-center"><span class="badge bg-info">{{ $mhs->status_pkl }}</span></td>
                            <td class="text-center">
                                <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" action="{{ route('datamahasiswa.destroy', $mhs->id) }}" method="POST">
                                    <a href="{{ route('datamahasiswa.show', $mhs->id) }}" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('datamahasiswa.edit', $mhs->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
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
            {{ $mahasiswas->links() }}
        </div>
    </div>
</div>
@endsection