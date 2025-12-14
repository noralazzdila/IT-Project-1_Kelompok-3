@extends('layouts.app')

@section('title', 'Manajemen Bimbingan PKL')

@section('content')

        <div class="container mt-4 flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Detail Bimbingan: {{ $bimbingan->mahasiswa_nama }}</h6>
                <a href="{{ route('bimbingan.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card shadow-sm p-4">
                <dl class="row">
                    <dt class="col-sm-3 detail-label">Nama Mahasiswa</dt>
                    <dd class="col-sm-9">{{ $bimbingan->mahasiswa_nama }}</dd>

                    <dt class="col-sm-3 detail-label">NIM</dt>
                    <dd class="col-sm-9">{{ $bimbingan->nim }}</dd>

                    <dt class="col-sm-3 detail-label">Dosen Pembimbing</dt>
                    <dd class="col-sm-9">{{ $bimbingan->dosen_pembimbing }}</dd>

                    <dt class="col-sm-3 detail-label">Tanggal</dt>
                    <dd class="col-sm-9">{{ $bimbingan->tanggal_bimbingan->format('d F Y') }}</dd>

                    <dt class="col-sm-3 detail-label">Topik</dt>
                    <dd class="col-sm-9">{{ $bimbingan->topik_bimbingan }}</dd>

                    <dt class="col-sm-3 detail-label">Status</dt>
                    <dd class="col-sm-9">
                        @if($bimbingan->status == 'Disetujui')
                            <span class="badge bg-success">{{ $bimbingan->status }}</span>
                        @elseif($bimbingan->status == 'Revisi')
                            <span class="badge bg-warning text-dark">{{ $bimbingan->status }}</span>
                        @else
                            <span class="badge bg-secondary">{{ $bimbingan->status }}</span>
                        @endif
                    </dd>

                    <dt class="col-sm-3 detail-label mt-3">Catatan</dt>
                    <dd class="col-sm-9 mt-3"><p style="text-align: justify;">{{ $bimbingan->catatan }}</p></dd>
                </dl>
            </div>
        </div>

@endsection