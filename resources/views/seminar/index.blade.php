@extends('layouts.app')

@section('title', 'Manajemen Seminar PKL')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Daftar Jadwal Seminar PKL</h2>
    <a href="{{ route('seminar.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Jadwal Seminar
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
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
                                <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" action="{{ route('seminar.destroy', $seminar->id) }}" method="POST">
                                    <a href="{{ route('seminar.show', $seminar->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('seminar.edit', $seminar->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
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
        {{-- Link Paginasi --}}
        <div class="mt-3">
            {{ $seminars->links() }}
        </div>
    </div>
</div>
@endsection