@extends('layouts.app')

@section('title', 'Kelola Nilai Mahasiswa')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <h6 class="fw-bold">Daftar Nilai Mahasiswa</h6>
        <a href="{{ route('nilai.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Nilai
        </a>
    </div>

    <div class="card shadow-sm p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>IPK</th>

                        <th>SKS D</th>
                        <th>Nilai E</th>
                        <th>Total SKS</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilai as $i => $s)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $s->mahasiswa->nama ?? '-' }}</td>
                        <td>{{ $s->mahasiswa->nim ?? '-' }}</td>
                        <td>{{ number_format($s->ipk, 2) ?? '-' }}</td>   
                        <td>{{ $s->sks_d }}</td>
                        <td>{{ $s->count_e }}</td>
                        <td>{{ $s->total_sks }}</td>
                         <td>
                            <span class="badge bg-{{ $s->status_color }}">{{ $s->status }}</span>
                        </td>
                        <td>
                            <a href="{{ route('nilai.show', $s->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('nilai.edit', $s->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('nilai.destroy', $s->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin hapus data mahasiswa ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data nilai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection