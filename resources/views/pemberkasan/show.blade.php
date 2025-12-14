@extends('layouts.app')

@section('title', 'Manajemen Pemberkasan PKL')

@section('content')
        {{-- DETAIL BERKAS --}}
        <div class="container mt-4 flex-grow-1">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Data Pemberkasan</h4>
                    <a href="{{ route('pemberkasan.index') }}" class="btn btn-light">
                        <i class="fa-solid fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>

                <div class="card-body">

                    {{-- INFORMASI MAHASISWA --}}
                    <h5 class="mb-3 text-primary"><i class="fa-solid fa-user-graduate me-2"></i>Informasi Mahasiswa</h5>
                    <div class="row mb-4">
                        <div class="col-md-6"><span class="info-label">Nama:</span> {{ $pemberkasan->mahasiswa->nama ?? '-' }}</div>
                        <div class="col-md-6"><span class="info-label">NIM:</span> {{ $pemberkasan->mahasiswa->nim ?? '-' }}</div>
                        <div class="col-md-6"><span class="info-label">Program Studi:</span> {{ $pemberkasan->mahasiswa->prodi ?? '-' }}</div>
                        <div class="col-md-6"><span class="info-label">Kelas:</span> {{ $pemberkasan->mahasiswa->kelas ?? '-' }}</div>
                        <div class="col-md-6"><span class="info-label">Dosen Pembimbing:</span> {{ $pemberkasan->mahasiswa->dosen_pembimbing ?? '-' }}</div>
                        <div class="col-md-6"><span class="info-label">Tempat PKL:</span> {{ $pemberkasan->mahasiswa->tempat_pkl ?? '-' }}</div>
                    </div>

                    <hr>

                    {{-- FILE BERKAS --}}
                    <h5 class="mb-3 text-primary"><i class="fa-solid fa-folder-open me-2"></i>Berkas Pemberkasan</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="file-box">
                                <h6><i class="fa-solid fa-file-alt me-2"></i>Form Bimbingan</h6>
                                @if($pemberkasan->form_bimbingan_path)
                                    <p class="file-name">{{ basename($pemberkasan->form_bimbingan_path) }}</p>
                                    <a href="{{ route('pemberkasan.file', ['pemberkasan' => $pemberkasan, 'field' => 'form_bimbingan']) }}" target="_blank" class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-eye me-1"></i> Lihat File
                                    </a>
                                @else
                                    <span class="badge bg-danger">Belum Diupload</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="file-box">
                                <h6><i class="fa-solid fa-certificate me-2"></i>Sertifikat</h6>
                                @if($pemberkasan->sertifikat_path)
                                    <p class="file-name">{{ basename($pemberkasan->sertifikat_path) }}</p>
                                    <a href="{{ route('pemberkasan.file', ['pemberkasan' => $pemberkasan, 'field' => 'sertifikat']) }}" target="_blank" class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-eye me-1"></i> Lihat File
                                    </a>
                                @else
                                    <span class="badge bg-danger">Belum Diupload</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="file-box">
                                <h6><i class="fa-solid fa-book me-2"></i>Laporan Final</h6>
                                @if($pemberkasan->laporan_final_path)
                                    <p class="file-name">{{ basename($pemberkasan->laporan_final_path) }}</p>
                                    <a href="{{ route('pemberkasan.file', ['pemberkasan' => $pemberkasan, 'field' => 'laporan_final']) }}" target="_blank" class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-eye me-1"></i> Lihat File
                                    </a>
                                @else
                                    <span class="badge bg-danger">Belum Diupload</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- STATUS --}}
                    <div class="mb-3">
                        <h6><i class="fa-solid fa-check-circle me-2"></i>Status Pemberkasan:</h6>
                        <span class="badge bg-{{ $pemberkasan->is_lengkap ? 'primary' : 'warning text-dark' }}">
                            {{ $pemberkasan->is_lengkap ? 'Lengkap' : 'Belum Lengkap' }}
                        </span>
                    </div>

                    <hr>

                    {{-- AKSI --}}
                    <div class="text-end">
                        <a href="{{ route('pemberkasan.edit', $pemberkasan->id) }}" class="btn btn-warning">
                            <i class="fa-solid fa-pen me-1"></i> Edit Data
                        </a>
                        <form action="{{ route('pemberkasan.destroy', $pemberkasan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini? Semua file terkait akan dihapus.');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">
                                <i class="fa-solid fa-trash me-1"></i> Hapus
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

@endsection