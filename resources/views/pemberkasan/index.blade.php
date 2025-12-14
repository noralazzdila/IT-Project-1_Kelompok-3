@extends('layouts.app')

@section('title', 'Manajemen Pemberkasan PKL')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Daftar Status Pemberkasan Mahasiswa</h4>
        <a href="{{ route('pemberkasan.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-upload me-2"></i> Upload Berkas
        </a>
    </div>

    <div class="card-body">
        {{-- Alert sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tabel --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Mahasiswa</th>
                        <th>Form Bimbingan</th>
                        <th>Sertifikat</th>
                        <th>Laporan Final</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemberkasan as $berkas)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $berkas->mahasiswa->nama ?? 'N/A' }}</strong><br>
                            <small class="text-muted">{{ $berkas->mahasiswa->nim ?? '-' }}</small>
                        </td>

                        {{-- Form Bimbingan --}}
                        <td class="text-center">
                            @if($berkas->form_bimbingan_path)
                                <a href="{{ route('pemberkasan.file', ['pemberkasan' => $berkas, 'field' => 'form_bimbingan']) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fa-solid fa-eye me-1"></i> Lihat File
                                </a>
                            @else
                                <span class="badge bg-danger">X Belum</span>
                            @endif
                        </td>

                        {{-- Sertifikat --}}
                        <td class="text-center">
                            @if($berkas->sertifikat_path)
                                <a href="{{ route('pemberkasan.file', ['pemberkasan' => $berkas, 'field' => 'sertifikat']) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fa-solid fa-eye me-1"></i> Lihat File
                                </a>
                            @else
                                <span class="badge bg-danger">X Belum</span>
                            @endif
                        </td>

                        {{-- Laporan Final --}}
                        <td class="text-center">
                            @if($berkas->laporan_final_path)
                                <a href="{{ route('pemberkasan.file', ['pemberkasan' => $berkas, 'field' => 'laporan_final']) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fa-solid fa-eye me-1"></i> Lihat File
                                </a>
                            @else
                                <span class="badge bg-danger">X Belum</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="text-center">
                            <span class="badge bg-{{ $berkas->is_lengkap ? 'primary' : 'warning text-dark' }}">
                                {{ $berkas->is_lengkap ? 'Lengkap' : 'Belum Lengkap' }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="text-center">
                            <a href="{{ route('pemberkasan.show', $berkas->id) }}" class="btn btn-sm btn-info text-white" title="Detail">
                                <i class="fa-solid fa-circle-info"></i>
                            </a>
                            <a href="{{ route('pemberkasan.edit', $berkas->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <form action="{{ route('pemberkasan.destroy', $berkas->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data pemberkasan ini? Seluruh file terkait akan dihapus permanen.');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            <div class="alert alert-secondary mb-0">
                                Belum ada data pemberkasan yang diunggah.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $pemberkasan->links() }}
        </div>
    </div>
</div>
@endsection