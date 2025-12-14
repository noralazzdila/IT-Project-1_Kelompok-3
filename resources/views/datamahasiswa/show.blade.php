@extends('layouts.app')

@section('title', 'Manajemen Data Mahasiswa')

@section('content')

        <div class="container mt-4 flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Profil Mahasiswa: {{ $datamahasiswa->nama }}</h6>
                <a href="{{ route('datamahasiswa.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card shadow-sm p-4">
                <h5 class="mb-4 border-bottom pb-2">Data Pribadi</h5>
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

                <h5 class="mt-4 mb-4 border-bottom pb-2">Data Akademik & PKL</h5>
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
                            <dd class="col-sm-7"><span class="badge bg-success">{{ $datamahasiswa->status_pkl }}</span></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
@endsection