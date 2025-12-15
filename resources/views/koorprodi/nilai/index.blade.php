@extends('koorprodi.layouts.app')

@section('title', 'Kelola Nilai Mahasiswa')
@section('header-title', 'Kelola Nilai Mahasiswa')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('koorprodi.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kelola Nilai</li>
        </ol>
    </nav>

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

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
                        <th>Status Kelayakan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilai as $i => $s)
                    <tr>
                        <td>{{ $nilai->firstItem() + $i }}</td>
                        <td>{{ $s->mahasiswa->nama ?? '-' }}</td>
                        <td>{{ $s->mahasiswa->nim ?? '-' }}</td>
                        <td>{{ number_format($s->ipk, 2) ?? '-' }}</td>   
                        <td>{{ $s->sks_d }}</td>
                        <td>{{ $s->count_e }}</td>
                        <td>{{ $s->total_sks }}</td>
                         <td>
                            <span class="badge bg-{{ $s->status_color }}">{{ $s->status }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('nilai.show', $s->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                <i class="fa fa-eye"></i>
                            </a>
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
        <div class="mt-3">
            {{ $nilai->links() }}
        </div>
    </div>
</div>
@endsection
