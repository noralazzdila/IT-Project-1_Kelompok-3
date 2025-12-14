@extends('dosen.layouts.app')

@section('title', 'Detail Surat Pengantar')

@section('header-title', 'Detail Surat Pengantar')

@section('content')
<div class="container mt-4 flex-grow-1">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Detail Surat Pengantar: {{ $suratpengantar->nama_mahasiswa }}</h6>
        <a href="{{ route('dosen.suratpengantar.indexdosen') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow-sm p-4">
        <dl class="row">
            <dt class="col-sm-3 detail-label">Nama Mahasiswa</dt>
            <dd class="col-sm-9">{{ $suratpengantar->nama_mahasiswa }}</dd>

            <dt class="col-sm-3 detail-label">NIM</dt>
            <dd class="col-sm-9">{{ $suratpengantar->nim }}</dd>

            <dt class="col-sm-3 detail-label">Program Studi</dt>
            <dd class="col-sm-9">{{ $suratpengantar->prodi }}</dd>

            <dt class="col-sm-3 detail-label">Tempat PKL</dt>
            <dd class="col-sm-9">{{ $suratpengantar->tempat_pkl }}</dd>
            
            <dt class="col-sm-3 detail-label">Alamat Perusahaan</dt>
            <dd class="col-sm-9">{{ $suratpengantar->alamat_perusahaan }}</dd>

            <dt class="col-sm-3 detail-label">Tanggal Pengajuan</dt>
            <dd class="col-sm-9">{{ \Carbon\Carbon::parse($suratpengantar->tanggal_pengajuan)->isoFormat('D MMMM Y') }}</dd>

            <dt class="col-sm-3 detail-label">Status</dt>
            <dd class="col-sm-9">
                @if($suratpengantar->status == 'Diterima')
                    <span class="badge bg-success">{{ $suratpengantar->status }}</span>
                @elseif($suratpengantar->status == 'Ditolak')
                    <span class="badge bg-danger">{{ $suratpengantar->status }}</span>
                @else
                    <span class="badge bg-warning text-dark">{{ $suratpengantar->status }}</span>
                @endif
            </dd>

            <dt class="col-sm-3 detail-label mt-3">File Surat</dt>
            <dd class="col-sm-9 mt-3">
                @if($suratpengantar->file_surat)
                    <a href="{{ asset('storage/' . $suratpengantar->file_surat) }}" target="_blank" class="btn btn-sm btn-info">
                        <i class="fa fa-file-pdf"></i> Lihat File
                    </a>
                @else
                    <span class="text-muted">Tidak ada file</span>
                @endif
            </dd>

            <dt class="col-sm-3 detail-label mt-3">Catatan</dt>
            <dd class="col-sm-9 mt-3"><p style="text-align: justify;">{{ $suratpengantar->catatan ?? '-' }}</p></dd>
        </dl>
    </div>
</div>
@endsection
