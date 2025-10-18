@extends('staf.layouts.app')

@section('title', 'Kelola Data Mahasiswa - Staf')

@section('header-title', 'Kelola Data Mahasiswa')

@section('content')
<div class="container mt-4 flex-grow-1">
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <h6 class="fw-bold">Daftar Mahasiswa</h6>
        <a href="{{ route('staf.datamahasiswa.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Mahasiswa
        </a>
    </div>

    <div class="card shadow-sm p-3">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Prodi</th>
                    <th>Kelas</th>
                    <th>Dosen Pembimbing</th>
                    <th>Tempat PKL</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswas as $i => $mhs)
                <tr>
                    <td>{{ $mahasiswas->firstItem() + $i }}</td>
                    <td>{{ $mhs->nim }}</td>
                    <td>{{ $mhs->nama }}</td>
                    <td>{{ $mhs->prodi }}</td>
                    <td>{{ $mhs->kelas }}</td>
                    <td>{{ $mhs->dosen_pembimbing }}</td>
                    <td>{{ $mhs->tempat_pkl }}</td>
                    <td><span class="badge bg-info">{{ $mhs->status_pkl }}</span></td>
                    <td>
                        <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" action="{{ route('staf.datamahasiswa.destroy', $mhs->id) }}" method="POST">
                            <a href="{{ route('staf.datamahasiswa.show', $mhs->id) }}" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('staf.datamahasiswa.edit', $mhs->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil"></i></a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada data mahasiswa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $mahasiswas->links() }}
        </div>
    </div>
</div>
@endsection
