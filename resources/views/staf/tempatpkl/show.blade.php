@extends('staf.layouts.app')

@section('title', 'Detail Tempat PKL - Staf')

@section('header-title', 'Detail Tempat PKL')

@section('content')
<div class="container mt-4 flex-grow-1">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Detail Perusahaan: {{ $tempatpkl->nama_perusahaan }}</h6>
        <a href="{{ route('staf.tempatpkl.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4 detail-list">
            <dl>
                <div class="row">
                    <dt class="col-sm-4">Nama Perusahaan</dt>
                    <dd class="col-sm-8">{{ $tempatpkl->nama_perusahaan }}</dd>
                </div>
                <div class="row">
                    <dt class="col-sm-4">Alamat Perusahaan</dt>
                    <dd class="col-sm-8">{{ $tempatpkl->alamat_perusahaan }}</dd>
                </div>
                <div class="row">
                    <dt class="col-sm-4">Jarak Lokasi</dt>
                    <dd class="col-sm-8">{{ $tempatpkl->jarak_lokasi ? $tempatpkl->jarak_lokasi . ' km' : '-' }}</dd>
                </div>
                <div class="row">
                    <dt class="col-sm-4">Reputasi Perusahaan</dt>
                    <dd class="col-sm-8">{{ $tempatpkl->reputasi_perusahaan }}</dd>
                </div>
                <div class="row">
                    <dt class="col-sm-4">Fasilitas</dt>
                    <dd class="col-sm-8">{{ $tempatpkl->fasilitas }}</dd>
                </div>
                <div class="row">
                    <dt class="col-sm-4">Kesesuaian Program Magang</dt>
                    <dd class="col-sm-8">{{ $tempatpkl->kesesuaian_program }}</dd>
                </div>
                <div class="row">
                    <dt class="col-sm-4">Lingkungan Kerja</dt>
                    <dd class="col-sm-8">{{ $tempatpkl->lingkungan_kerja }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
