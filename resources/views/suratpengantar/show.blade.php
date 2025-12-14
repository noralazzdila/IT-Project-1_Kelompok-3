@extends('layouts.app')

@section('title', 'Manajemen Surat Pengantar PKL')

@section('content')
        <div class="container mt-4 flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Detail Surat: {{ $suratpengantar->nama_mahasiswa }}</h6>
                <a href="{{ route('suratpengantar.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card shadow-sm p-4">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <p class="detail-label mb-1">NIM / Nama</p>
                        <h5>{{ $suratpengantar->nim }} / {{ $suratpengantar->nama_mahasiswa }}</h5>
                    </div>
                    <div class="col-md-4">
                        <p class="detail-label mb-1">Program Studi</p>
                        <h5>{{ $suratpengantar->prodi }}</h5>
                    </div>
                     <div class="col-md-4">
                        <p class="detail-label mb-1">Tanggal Pengajuan</p>
                        <h5>{{ \Carbon\Carbon::parse($suratpengantar->tanggal_pengajuan)->translatedFormat('d F Y') }}</h5>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p class="detail-label mb-1">Tempat PKL</p>
                        <p>{{ $suratpengantar->tempat_pkl }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="detail-label mb-1">Alamat Perusahaan</p>
                        <p>{{ $suratpengantar->alamat_perusahaan }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="detail-label mb-1">Status</p>
                        @php
                            $badgeClass = match($suratpengantar->status) {
                                'Menunggu' => 'bg-warning text-dark',
                                'Diproses' => 'bg-primary',
                                'Selesai' => 'bg-success',
                                default => 'bg-secondary',
                            };
                        @endphp
                        <p><span class="badge fs-6 {{ $badgeClass }}">{{ $suratpengantar->status }}</span></p>
                    </div>
                     <div class="col-md-6 mb-3">
                        <p class="detail-label mb-1">File Surat</p>
                        @if ($suratpengantar->file_surat)
                            <a href="{{ route('suratpengantar.file', $suratpengantar) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-download"></i> Unduh File
                            </a>
                        @else
                            <span class="text-muted">File belum diunggah.</span>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <p class="detail-label mb-1">Catatan</p>
                        <div class="p-3 bg-light rounded border">
                            {!! nl2br(e($suratpengantar->catatan ?? 'Tidak ada catatan.')) !!}
                        </div>
                    </div>
                </div>

                @if ($suratpengantar->file_surat && Storage::exists('public/' . $suratpengantar->file_surat))
                <div class="mt-4">
                    <h6 class="mb-3">Preview File Surat</h6>
                    <iframe src="{{ route('suratpengantar.file', $suratpengantar) }}" width="100%" height="600px" class="border rounded"></iframe>
                </div>
                @endif
            </div>
        </div>
@endsection