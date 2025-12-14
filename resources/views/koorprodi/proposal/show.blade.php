@extends('koorprodi.layouts.app')

@section('title', 'Detail Proposal - Koordinator Prodi')

@section('header-title', 'Detail Proposal')

@section('content')
<div class="container mt-4 flex-grow-1">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Detail Proposal: {{ $proposal->nama_mahasiswa }}</h6>
        <a href="{{ route('koorprodi.proposal.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow-sm p-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <p class="detail-label mb-1">NIM</p>
                <p class="fs-5">{{ $proposal->nim }}</p>
            </div>
            <div class="col-md-6 mb-3">
                <p class="detail-label mb-1">Nama Mahasiswa</p>
                <p class="fs-5">{{ $proposal->nama_mahasiswa }}</p>
            </div>
            <div class="col-md-12 mb-3">
                 <p class="detail-label mb-1">Judul Proposal</p>
                <p class="fs-5">{{ $proposal->judul_proposal }}</p>
            </div>
            <div class="col-md-6 mb-3">
                <p class="detail-label mb-1">Dosen Pembimbing</p>
                <p>{{ $proposal->pembimbing }}</p>
            </div>
            <div class="col-md-6 mb-3">
                <p class="detail-label mb-1">Tempat PKL</p>
                <p>{{ $proposal->tempat_pkl }}</p>
            </div>
            <hr>
            <div class="col-md-4 mb-3">
                <p class="detail-label mb-1">Tanggal Pengajuan</p>
                <p>{{ \Carbon\Carbon::parse($proposal->tanggal_pengajuan)->translatedFormat('d F Y') }}</p>
            </div>
            <div class="col-md-4 mb-3">
                <p class="detail-label mb-1">Status</p>
                @php
                    $badgeClass = '';
                    if ($proposal->status == 'Menunggu') $badgeClass = 'bg-warning text-dark';
                    elseif ($proposal->status == 'Disetujui') $badgeClass = 'bg-success';
                    elseif ($proposal->status == 'Ditolak') $badgeClass = 'bg-danger';
                @endphp
                <p><span class="badge fs-6 {{ $badgeClass }}">{{ $proposal->status }}</span></p>
            </div>
            <div class="col-md-4 mb-3">
                <p class="detail-label mb-1">File Proposal</p>
                <a href="{{ route('proposal.file', $proposal) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-download"></i> Unduh File
                </a>
            </div>
            <div class="col-md-12 mb-3">
                <p class="detail-label mb-1">Catatan</p>
                <div class="p-3 bg-light rounded border">
                    {!! nl2br(e($proposal->catatan ?? 'Tidak ada catatan.')) !!}
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h6 class="mb-3">Preview File Proposal</h6>
             @if($proposal->file_proposal && Storage::exists('public/' . $proposal->file_proposal))
                <iframe src="{{ route('proposal.file', $proposal) }}" width="100%" height="600px" class="border rounded"></iframe>
            @else
                <div class="alert alert-warning">File tidak ditemukan.</div>
            @endif
        </div>
    </div>
</div>
@endsection
