@extends('dosen.layouts.app')

@section('title', 'Detail Jadwal Seminar')

@section('header-title', 'Detail Jadwal Seminar')

@section('content')
        <div class="container mt-4 flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Detail Seminar: {{ $seminar->nama_mahasiswa }}</h6>
                <div>
                    <a href="{{ route('dosen.seminar.indexdosen') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    <a href="{{ route('dosen.seminar.editdosen', $seminar->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
                </div>
            </div>

            <div class="card shadow-sm p-4">
                <div class="mb-3">
                    <h5 class="fw-bold border-bottom pb-2">Judul Laporan</h5>
                    <p class="mt-2">{{ $seminar->judul }}</p>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5 class="fw-bold">Mahasiswa</h5>
                        <p class="mb-0">{{ $seminar->nama_mahasiswa }}</p>
                        <p class="text-muted">{{ $seminar->nim }}</p>
                    </div>
                     <div class="col-md-6 mb-3">
                        <h5 class="fw-bold">Dosen</h5>
                        <p class="mb-0"><strong>Pembimbing:</strong> {{ $seminar->nama_pembimbing }}</p>
                        <p class="mb-0"><strong>Penguji:</strong> {{ $seminar->nama_penguji }}</p>
                    </div>
                </div>
                <hr>
                 <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5 class="fw-bold">Tanggal & Waktu</h5>
                        <p class="mb-0">{{ \Carbon\Carbon::parse($seminar->tanggal)->isoFormat('dddd, D MMMM Y') }}</p>
                        <p class="text-muted">{{ date('H:i', strtotime($seminar->jam_mulai)) }} - {{ date('H:i', strtotime($seminar->jam_selesai)) }} WITA</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h5 class="fw-bold">Ruang Seminar</h5>
                        <p>{{ $seminar->ruang }}</p>
                    </div>
                </div>
            </div>
        </div>
@endsection