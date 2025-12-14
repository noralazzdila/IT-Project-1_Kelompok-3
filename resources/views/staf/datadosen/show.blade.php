@extends('staf.layouts.app')

@section('title', 'Detail Data Dosen - Staf')

@section('header-title', 'Detail Data Dosen')

@section('content')
<div class="card shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Detail Dosen</h5>
        <a href="{{ route('staf.datadosen.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <dl class="row">
        <dt class="col-sm-3">Nama Lengkap</dt>
        <dd class="col-sm-9">{{ $dosen->nama }}</dd>

        <dt class="col-sm-3">NIP</dt>
        <dd class="col-sm-9">{{ $dosen->nip }}</dd>

        <dt class="col-sm-3">Email</dt>
        <dd class="col-sm-9">{{ $dosen->email }}</dd>

        <dt class="col-sm-3">Program Studi</dt>
        <dd class="col-sm-9">{{ $dosen->prodi }}</dd>

        <dt class="col-sm-3">Tanggal Dibuat</dt>
        <dd class="col-sm-9">{{ $dosen->created_at->isoFormat('D MMMM Y, HH:mm') }}</dd>

        <dt class="col-sm-3">Tanggal Diperbarui</dt>
        <dd class="col-sm-9">{{ $dosen->updated_at->isoFormat('D MMMM Y, HH:mm') }}</dd>
    </dl>
</div>
@endsection
