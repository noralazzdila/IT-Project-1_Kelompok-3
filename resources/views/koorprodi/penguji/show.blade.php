@extends('koorprodi.layouts.app')

@section('title', 'Detail Data Penguji - Koordinator Prodi')

@section('header-title', 'Detail Data Penguji')

@section('content')
<div class="container mt-4 flex-grow-1">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Detail Penguji: {{ $penguji->nama_penguji }}</h6>
        <a href="{{ route('koorprodi.penguji.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow-sm p-4">
        <dl class="row">
            <dt class="col-sm-3 detail-label">Nama Penguji</dt>
            <dd class="col-sm-9">{{ $penguji->nama_penguji }}</dd>

            <dt class="col-sm-3 detail-label">NIP</dt>
            <dd class="col-sm-9">{{ $penguji->nip }}</dd>

            <dt class="col-sm-3 detail-label">Email</dt>
            <dd class="col-sm-9">{{ $penguji->email }}</dd>

            <dt class="col-sm-3 detail-label">No. Telepon</dt>
            <dd class="col-sm-9">{{ $penguji->no_telepon }}</dd>

            <dt class="col-sm-3 detail-label">Jabatan</dt>
            <dd class="col-sm-9">{{ $penguji->jabatan }}</dd>
            
            <hr class="my-3">

            <dt class="col-sm-3 detail-label">Dibuat Pada</dt>
            <dd class="col-sm-9">{{ $penguji->created_at->format('d M Y, H:i') }}</dd>

            <dt class="col-sm-3 detail-label">Diperbarui Pada</dt>
            <dd class="col-sm-9">{{ $penguji->updated_at->format('d M Y, H:i') }}</dd>
        </dl>
    </div>
</div>
@endsection
