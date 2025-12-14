@extends('dosen.layouts.app')

@section('title', 'Detail Data Mahasiswa')

@section('header-title', 'Detail Data Mahasiswa')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dosen.datamahasiswa.index') }}">Kelola Mahasiswa</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Mahasiswa</li>
    </ol>
</nav>

<div class="card rounded-3 shadow-sm border-0">
    <div class="card-header text-white" style="background-color: #113F67;">
        <h5 class="mb-0"><i class="fa-solid fa-user-graduate me-2"></i>Detail Data Mahasiswa</h5>
    </div>
    <div class="card-body">
        <h6 class="mb-4 border-bottom pb-2">Data Pribadi</h6>
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-5 detail-label">Nama Lengkap</dt>
                    <dd class="col-sm-7">{{ $datamahasiswa->nama }}</dd>

                    <dt class="col-sm-5 detail-label">NIM</dt>
                    <dd class="col-sm-7">{{ $datamahasiswa->nim }}</dd>

                    <dt class="col-sm-5 detail-label">Jenis Kelamin</dt>
                    <dd class="col-sm-7">{{ $datamahasiswa->jenis_kelamin }}</dd>

                    <dt class="col-sm-5 detail-label">Tanggal Lahir</dt>
                    <dd class="col-sm-7">{{ $datamahasiswa->tanggal_lahir }}</dd>
                </dl>
            </div>
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-5 detail-label">Email</dt>
                    <dd class="col-sm-7">{{ $datamahasiswa->email }}</dd>
                    
                    <dt class="col-sm-5 detail-label">No. HP</dt>
                    <dd class="col-sm-7">{{ $datamahasiswa->no_hp }}</dd>
                </dl>
            </div>
        </div>

        <h6 class="mt-4 mb-4 border-bottom pb-2">Data Akademik & PKL</h6>
        <div class="row">
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-5 detail-label">Program Studi</dt>
                    <dd class="col-sm-7">{{ $datamahasiswa->prodi }}</dd>

                    <dt class="col-sm-5 detail-label">Kelas</dt>
                    <dd class="col-sm-7">{{ $datamahasiswa->kelas }}</dd>

                    <dt class="col-sm-5 detail-label">Tahun Angkatan</dt>
                    <dd class="col-sm-7">{{ $datamahasiswa->tahun_angkatan }}</dd>
                </dl>
            </div>
            <div class="col-md-6">
                <dl class="row">
                    <dt class="col-sm-5 detail-label">Dosen Pembimbing</dt>
                    <dd class="col-sm-7">{{ $datamahasiswa->dosen_pembimbing }}</dd>
                    
                    <dt class="col-sm-5 detail-label">Tempat PKL</dt>
                    <dd class="col-sm-7">{{ $datamahasiswa->tempat_pkl }}</dd>

                    <dt class="col-sm-5 detail-label">Status PKL</dt>
                    <dd class="col-sm-7">
                        <span class="badge 
                            @if($datamahasiswa->status_pkl == 'Belum Mulai') bg-secondary 
                            @elseif($datamahasiswa->status_pkl == 'Sedang PKL') bg-warning text-dark
                            @elseif($datamahasiswa->status_pkl == 'Selesai') bg-success
                            @endif fs-6">
                            {{ $datamahasiswa->status_pkl }}
                        </span>
                    </dd>
                </dl>
            </div>
        </div>

        <div class="mt-4 text-end">
            <a href="{{ route('dosen.datamahasiswa.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection