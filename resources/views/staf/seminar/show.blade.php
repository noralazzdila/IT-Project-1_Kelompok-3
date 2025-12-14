@extends('staf.layouts.app')

@section('title', 'Detail Jadwal Seminar')

@section('header-title', 'Detail Jadwal Seminar')

@section('content')
<div class="card shadow-sm p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Detail Seminar: {{ $seminar->nama_mahasiswa }}</h5>
        <a href="{{ route('staf.seminar.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <dl class="row">
        <dt class="col-sm-3">Judul Laporan</dt>
        <dd class="col-sm-9">{{ $seminar->judul }}</dd>

        <dt class="col-sm-3">Nama Mahasiswa</dt>
        <dd class="col-sm-9">{{ $seminar->nama_mahasiswa }}</dd>

        <dt class="col-sm-3">NIM</dt>
        <dd class="col-sm-9">{{ $seminar->nim }}</dd>

        <dt class="col-sm-3">Dosen Pembimbing</dt>
        <dd class="col-sm-9">{{ $seminar->nama_pembimbing }}</dd>

        <dt class="col-sm-3">Dosen Penguji</dt>
        <dd class="col-sm-9">{{ $seminar->nama_penguji }}</dd>
        
        <hr class="my-3">

        <dt class="col-sm-3">Jadwal</dt>
        <dd class="col-sm-9">{{ \Carbon\Carbon::parse($seminar->tanggal)->isoFormat('dddd, D MMMM Y') }}, {{ date('H:i', strtotime($seminar->jam_mulai)) }} - {{ date('H:i', strtotime($seminar->jam_selesai)) }}</dd>
        
        <dt class="col-sm-3">Ruang</dt>
        <dd class="col-sm-9">{{ $seminar->ruang }}</dd>

    </dl>
    
    <div class="mt-3">
        <a href="{{ route('staf.seminar.edit', $seminar->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> Edit Jadwal</a>
    </div>
</div>
@endsection
