@extends('koorprodi.layouts.app')

@section('title', 'Kelola Penguji - Koordinator Prodi')

@section('header-title', 'Kelola Penguji')

@section('content')
<div class="container mt-4 flex-grow-1">
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <h6 class="fw-bold">Daftar Penguji</h6>
        <a href="{{ route('koorprodi.penguji.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Penguji
        </a>
    </div>

    <div class="card shadow-sm p-3">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Penguji</th>
                    <th>NIP</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengujis as $i => $penguji)
                <tr>
                    <td>{{ $pengujis->firstItem() + $i }}</td>
                    <td>{{ $penguji->nama_penguji }}</td>
                    <td>{{ $penguji->nip }}</td>
                    <td>{{ $penguji->email }}</td>
                    <td>{{ $penguji->no_telepon }}</td>
                    <td>{{ $penguji->jabatan }}</td>
                    <td>
                        <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" action="{{ route('koorprodi.penguji.destroy', $penguji->id) }}" method="POST">
                            <a href="{{ route('koorprodi.penguji.show', $penguji->id) }}" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('koorprodi.penguji.edit', $penguji->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil"></i></a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data penguji.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $pengujis->links() }}
        </div>
    </div>
</div>
@endsection
