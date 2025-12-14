@extends('dosen.layouts.app')

@section('title', 'Detail Data Proposal')

@section('header-title', 'Detail Data Proposal')

@section('content')
<div class="container mt-4 flex-grow-1">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Detail Proposal: {{ $proposal->nama_mahasiswa }}</h6>
        <a href="{{ route('dosen.proposal.indexdosen') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow-sm p-4">
        <dl class="row">
            <dt class="col-sm-3 detail-label">Nama Mahasiswa</dt>
            <dd class="col-sm-9">{{ $proposal->nama_mahasiswa }}</dd>

            <dt class="col-sm-3 detail-label">NIM</dt>
            <dd class="col-sm-9">{{ $proposal->nim }}</dd>

            <dt class="col-sm-3 detail-label">Judul Proposal</dt>
            <dd class="col-sm-9">{{ $proposal->judul_proposal }}</dd>

            <dt class="col-sm-3 detail-label">Dosen Pembimbing</dt>
            <dd class="col-sm-9">{{ $proposal->pembimbing }}</dd>

            <dt class="col-sm-3 detail-label">Tempat PKL</dt>
            <dd class="col-sm-9">{{ $proposal->tempat_pkl }}</dd>

            <dt class="col-sm-3 detail-label">Tanggal Pengajuan</dt>
            <dd class="col-sm-9">{{ \Carbon\Carbon::parse($proposal->tanggal_pengajuan)->isoFormat('D MMMM Y') }}</dd>

            <dt class="col-sm-3 detail-label">Status</dt>
            <dd class="col-sm-9">
                @if($proposal->status == 'Diterima')
                    <span class="badge bg-success">{{ $proposal->status }}</span>
                @elseif($proposal->status == 'Ditolak')
                    <span class="badge bg-danger">{{ $proposal->status }}</span>
                @else
                    <span class="badge bg-warning text-dark">{{ $proposal->status }}</span>
                @endif
            </dd>

            <dt class="col-sm-3 detail-label mt-3">File Proposal</dt>
            <dd class="col-sm-9 mt-3">
                @if($proposal->file_proposal)
                    <a href="{{ asset('storage/' . $proposal->file_proposal) }}" target="_blank" class="btn btn-sm btn-info">
                        <i class="fa fa-file-pdf"></i> Lihat File
                    </a>
                @else
                    <span class="text-muted">Tidak ada file</span>
                @endif
            </dd>

            <dt class="col-sm-3 detail-label mt-3">Catatan</dt>
            <dd class="col-sm-9 mt-3"><p style="text-align: justify;">{{ $proposal->catatan ?? '-' }}</p></dd>
        </dl>
    </div>
</div>
@endsection
