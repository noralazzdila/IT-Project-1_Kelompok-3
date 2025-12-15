@extends('koorprodi.layouts.app')

@section('title', 'Kelola Seminar')
@section('header-title', 'Manajemen Seminar')

@section('content')
<main class="container-fluid mt-4 flex-grow-1">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('koorprodi.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kelola Seminar</li>
        </ol>
    </nav>
    <div class="card rounded-3 shadow-sm">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <!-- Add Seminar button or other controls can go here -->
            </div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Tanggal Seminar</th>
                            <th>Waktu</th>
                            <th>Ruangan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="alert alert-info mb-0">
                                    Data Seminar tidak ditemukan atau belum tersedia.
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
