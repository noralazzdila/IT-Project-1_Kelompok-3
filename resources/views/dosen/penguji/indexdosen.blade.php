@extends('dosen.layouts.app')

@section('title', 'Kelola Data Penguji')

@section('header-title', 'Manajemen Data Penguji')

@section('content')
<div class="container-fluid mt-4 flex-grow-1">
    <div class="card shadow-sm">
        
        {{-- CARD HEADER --}}
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Data Penguji</h4>
            <a href="{{ route('dosen.penguji.createdosen') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-2"></i> Tambah Penguji
            </a>
        </div>

        <div class="card-body">
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
                            <th scope="col" class="text-center">No</th>
                            <th scope="col">Nama Penguji</th>
                            <th scope="col">NIP</th>
                            <th scope="col">Email</th>
                            <th scope="col">No Telepon</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengujis as $index => $penguji)
                            <tr>
                                <td class="text-center">{{ $pengujis->firstItem() + $index }}</td>
                                <td>{{ $penguji->nama_penguji }}</td>
                                <td>{{ $penguji->nip }}</td>
                                <td>{{ $penguji->email }}</td>
                                <td>{{ $penguji->no_telepon }}</td>
                                <td>{{ $penguji->jabatan }}</td>
                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');" action="{{ route('dosen.penguji.destroy', $penguji->id) }}" method="POST">
                                        <a href="{{ route('dosen.penguji.showdosen', $penguji->id) }}" class="btn btn-sm btn-info text-white"><i class="fa-solid fa-eye"></i></a>
                                        <a href="{{ route('dosen.penguji.editdosen', $penguji->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pencil"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="alert alert-warning mb-0">
                                        Data Penguji belum tersedia. Silakan tambahkan data baru.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
               {{ $pengujis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
