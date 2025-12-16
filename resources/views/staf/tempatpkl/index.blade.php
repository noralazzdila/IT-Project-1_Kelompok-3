@extends('staf.layouts.app')

@section('title', 'Kelola Tempat PKL - Staf')

@section('header-title', 'Kelola Tempat PKL')

@section('content')
<div class="container mt-4 flex-grow-1">
    <div class="card rounded-3 shadow-sm">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <a href="{{ route('staf.tempatpkl.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-2"></i> Tambah Tempat PKL
                </a>
                <form action="{{ route('staf.tempatpkl.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari perusahaan..." value="{{ request('search') }}" style="width: auto;">
                    <select name="reputasi_perusahaan" class="form-select" style="width: auto;">
                        <option value="">Semua Reputasi</option>
                        <option value="Sangat Baik" {{ request('reputasi_perusahaan') == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik</option>
                        <option value="Baik" {{ request('reputasi_perusahaan') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Cukup" {{ request('reputasi_perusahaan') == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                        <option value="Buruk" {{ request('reputasi_perusahaan') == 'Buruk' ? 'selected' : '' }}>Buruk</option>
                        <option value="Sangat Buruk" {{ request('reputasi_perusahaan') == 'Sangat Buruk' ? 'selected' : '' }}>Sangat Buruk</option>
                     </select>
                    <button type="submit" class="btn btn-info text-white">
                        <i class="fa-solid fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('staf.tempatpkl.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-sync me-1"></i> Reset
                    </a>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Perusahaan & Alamat</th>
                            <th>Mahasiswa (Nama / NIM)</th>
                            <th class="text-center">Jarak (km)</th>
                            <th class="text-center">Reputasi</th>
                            <th>Fasilitas</th>
                            <th>Lingkungan Kerja</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tempatpkl as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration + ($tempatpkl->currentPage() - 1) * $tempatpkl->perPage() }}</td>
                                <td>
                                    <strong>{{ $item->nama_perusahaan }}</strong><br>
                                    <small class="text-muted">{{ $item->alamat_perusahaan }}</small>
                                </td>
                                <td>
                                    {{ optional($item->mahasiswa)->nama }}
                                    @if(optional($item->mahasiswa)->nim)
                                        <br><small class="text-muted">({{ $item->mahasiswa->nim }})</small>
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->jarak_lokasi ?? '-' }}</td>
                                <td class="text-center">{{ $item->reputasi_perusahaan }}</td>
                                <td>{{ $item->fasilitas }}</td>
                                <td>{{ $item->lingkungan_kerja }}</td>
                                <td class="text-center">
                                    <form action="{{ route('staf.tempatpkl.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        <a href="{{ route('staf.tempatpkl.show', $item->id) }}" class="btn btn-sm btn-info text-white" title="Lihat"><i class="fa-solid fa-eye"></i></a>
                                        <a href="{{ route('staf.tempatpkl.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="alert alert-warning mb-0">
                                        Data tempat PKL tidak ditemukan atau belum tersedia.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-3">
                {{ $tempatpkl->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
