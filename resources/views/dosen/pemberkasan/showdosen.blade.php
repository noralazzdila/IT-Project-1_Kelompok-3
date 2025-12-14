@extends('dosen.layouts.app')

@section('title', 'Detail Data Pemberkasan')

@section('header-title', 'Detail Data Pemberkasan')

@section('content')
<div class="container mt-4 flex-grow-1">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Detail Pemberkasan: {{ $pemberkasan->mahasiswa->nama ?? 'N/A' }}</h6>
        <a href="{{ route('dosen.pemberkasan.indexdosen') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow-sm p-4">
        <dl class="row">
            <dt class="col-sm-3 detail-label">Nama Mahasiswa</dt>
            <dd class="col-sm-9">{{ $pemberkasan->mahasiswa->nama ?? 'N/A' }}</dd>

            <dt class="col-sm-3 detail-label">NIM</dt>
            <dd class="col-sm-9">{{ $pemberkasan->mahasiswa->nim ?? 'N/A' }}</dd>

            <dt class="col-sm-3 detail-label">Status Kelengkapan</dt>
            <dd class="col-sm-9">
                @if($pemberkasan->is_lengkap)
                    <span class="badge bg-success">Lengkap</span>
                @else
                    <span class="badge bg-warning text-dark">Belum Lengkap</span>
                @endif
            </dd>

            <dt class="col-sm-3 detail-label">Tanggal Verifikasi</dt>
            <dd class="col-sm-9">{{ $pemberkasan->tanggal_verifikasi ? \Carbon\Carbon::parse($pemberkasan->tanggal_verifikasi)->isoFormat('D MMMM Y') : 'Belum Diverifikasi' }}</dd>

            <hr class="my-3">

            <dt class="col-sm-3 detail-label">Form Bimbingan</dt>
            <dd class="col-sm-9">
                @if($pemberkasan->form_bimbingan_path)
                    <a href="{{ asset('storage/' . $pemberkasan->form_bimbingan_path) }}" target="_blank" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> Lihat</a>
                @else
                    <span class="text-muted">Tidak ada file</span>
                @endif
            </dd>

            <dt class="col-sm-3 detail-label mt-2">Sertifikat PKL</dt>
            <dd class="col-sm-9 mt-2">
                @if($pemberkasan->sertifikat_path)
                    <a href="{{ asset('storage/' . $pemberkasan->sertifikat_path) }}" target="_blank" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> Lihat</a>
                @else
                    <span class="text-muted">Tidak ada file</span>
                @endif
            </dd>

            <dt class="col-sm-3 detail-label mt-2">Laporan Final</dt>
            <dd class="col-sm-9 mt-2">
                @if($pemberkasan->laporan_final_path)
                    <a href="{{ asset('storage/' . $pemberkasan->laporan_final_path) }}" target="_blank" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> Lihat</a>
                @else
                    <span class="text-muted">Tidak ada file</span>
                @endif
            </dd>
            
        </dl>
    </div>
</div>
@endsection
