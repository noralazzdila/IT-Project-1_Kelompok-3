@extends('koorprodi.layouts.app')

@section('title', 'Detail Data Dosen')
@section('header-title', 'Detail Data Dosen')

@section('content')
<div class="container mt-4 flex-grow-1">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Profil Dosen: {{ $datadosen->nama }}</h6>
        <a href="{{ route('koorprodi.datadosen.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow-sm p-4">
        <h5 class="mb-4 border-bottom pb-2">Data Dosen</h5>
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-5 detail-label">Nama Lengkap</dt>
                    <dd class="col-sm-7">{{ $datadosen->nama }}</dd>

                    <dt class="col-sm-5 detail-label">NIP</dt>
                    <dd class="col-sm-7">{{ $datadosen->nip }}</dd>

                    <dt class="col-sm-5 detail-label">Jabatan</dt>
                    <dd class="col-sm-7">{{ $datadosen->jabatan }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
