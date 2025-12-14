@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
        <!-- Content -->
        <div class="container mt-4 flex-grow-1">
            <div class="card shadow-sm p-4">
                <h6 class="fw-bold mb-3"><i class="fa fa-user-circle me-2"></i> Informasi Lengkap User</h6>

                <div class="info-box">
                    <div class="row mb-3">
                        <div class="col-md-4 info-label">Nama Lengkap:</div>
                        <div class="col-md-8 info-value">{{ $user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 info-label">Email:</div>
                        <div class="col-md-8 info-value">{{ $user->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 info-label">Role / Hak Akses:</div>
                        <div class="col-md-8 info-value text-capitalize">{{ $user->role }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 info-label">NIP / NIM:</div>
                        <div class="col-md-8 info-value">{{ $user->identifier ?? '-' }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 info-label">Status Akun:</div>
                        <div class="col-md-8">
                            @if($user->status == 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 info-label">Tanggal Dibuat:</div>
                        <div class="col-md-8 info-value">{{ $user->created_at->format('d M Y, H:i') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 info-label">Terakhir Diperbarui:</div>
                        <div class="col-md-8 info-value">{{ $user->updated_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">
                        <i class="fa fa-edit"></i> Edit Data
                    </a>
                </div>
            </div>
        </div>

@endsection