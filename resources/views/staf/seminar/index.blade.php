@extends('staf.layouts.app')

@section('title', 'Kelola Data Seminar')

@section('header-title', 'Manajemen Data Seminar')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Jadwal Seminar PKL</h5>
        <a href="{{ route('staf.seminar.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Jadwal
        </a>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
             <form action="{{ route('staf.seminar.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari Mahasiswa/Judul..." value="{{ request('search') }}">
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
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Mahasiswa</th>
                        <th scope="col">Judul Seminar</th>
                        <th scope="col">Pembimbing</th>
                        <th scope="col">Penguji</th>
                        <th scope="col">Jadwal</th>
                        <th scope="col">Ruang</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($seminars as $seminar)
                        <tr>
                            <td>
                                <strong>{{ $seminar->nama_mahasiswa }}</strong><br>
                                <small class="text-muted">{{ $seminar->nim }}</small>
                            </td>
                            <td>{{ Str::limit($seminar->judul, 40) }}</td>
                            <td>{{ $seminar->nama_pembimbing }}</td>
                            <td>{{ $seminar->nama_penguji }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($seminar->tanggal)->isoFormat('dddd, D MMM Y') }}<br>
                                <small class="text-muted">{{ date('H:i', strtotime($seminar->jam_mulai)) }} - {{ date('H:i', strtotime($seminar->jam_selesai)) }}</small>
                            </td>
                            <td>{{ $seminar->ruang }}</td>
                            <td class="text-center">
                                <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" action="{{ route('staf.seminar.destroy', $seminar->id) }}" method="POST">
                                    <a href="{{ route('staf.seminar.show', $seminar->id) }}" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('staf.seminar.edit', $seminar->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada data seminar yang dijadwalkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $seminars->links() }}
        </div>
    </div>
</div>
@endsection
