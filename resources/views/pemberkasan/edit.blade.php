@extends('layouts.app')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemberkasan - Koordinator PKL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f5f7fa;
        }
        .wrapper { flex: 1; display: flex; }
        .sidebar {
            background: #ffffff;
            min-height: 100vh;
            padding-top: 20px;
            box-shadow: 2px 0 6px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: #333; font-weight: 500; margin-bottom: 5px; transition: all 0.3s ease;
        }
        .sidebar .nav-link.active {
            background: #113F67; color: #fff !important; border-radius: 8px;
        }
        .sidebar .nav-link:hover { background: #e9ecef; border-radius: 8px; }
        .header { background: #113F67; color: #fff; padding: 15px; box-shadow: 0px 2px 6px rgba(0,0,0,0.2); }
        .footer { background: #113F67; color: #fff; padding: 12px; text-align: center; margin-top: auto; }
    </style>
</head>
<body>
<div class="wrapper">
    {{-- Sidebar --}}
    <div class="col-2 sidebar">
        <div class="text-center mb-4">
            <img src="{{ asset('images/Logo_Politala.png') }}" width="80" alt="Logo">
            <h6 class="fw-bold mt-2">SIPRAKELRA</h6>
            <small class="text-muted">Sistem Informasi PKL</small>
        </div>
        <nav class="nav flex-column px-2">
            <a href="{{ route('koor.dashboard') }}" class="nav-link"><i class="fa fa-home me-2"></i> Beranda</a>
            <a href="{{ route('user.index') }}" class="nav-link"><i class="fa fa-users me-2"></i>User</a>
            <a href="{{ route('nilai.index') }}" class="nav-link"><i class="fa fa-graduation-cap me-2"></i>Nilai</a>
            <a href="{{ route('tempatpkl.index') }}" class="nav-link"><i class="fa fa-building me-2"></i>Tempat PKL</a>
            <a href="{{ route('datamahasiswa.index') }}" class="nav-link"><i class="fa fa-id-card me-2"></i>Data Mahasiswa</a>
            <a href="{{ route('bimbingan.index') }}" class="nav-link"><i class="fa fa-chalkboard-teacher me-2"></i>Bimbingan</a>
            <a href="{{ route('seminar.index') }}" class="nav-link"><i class="fa fa-calendar me-2"></i>Seminar</a>
            <a href="{{ route('penguji.index') }}" class="nav-link"><i class="fa fa-user-check me-2"></i>Penguji</a>
            <a href="{{ route('datadosen.index') }}" class="nav-link"><i class="fa fa-users me-2"></i>Data Dosen</a>
            <a href="{{ route('proposal.index') }}" class="nav-link"><i class="fa fa-file-signature me-2"></i> Proposal</a>
            <a href="{{ route('suratpengantar.index') }}" class="nav-link"><i class="fa fa-envelope me-2"></i>Surat Pengantar</a>
            <a href="{{ route('pemberkasan.index') }}" class="nav-link active"><i class="fa fa-folder me-2"></i>Pemberkasan</a>
        </nav>
    </div>

    {{-- Main Content --}}
    <div class="col-10 d-flex flex-column">
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Data Pemberkasan</h5>
            <div class="dropdown text-end">
                <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span><br>
                    <small>Koordinator PKL</small>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                    <li><a class="dropdown-item" href="#"><i class="fa fa-user-edit me-2"></i>Edit Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fa fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>

        <div class="container mt-4 flex-grow-1">
            <div class="card shadow-sm p-4">
                <h6 class="fw-bold mb-3">Formulir Edit Pemberkasan</h6>

                {{-- FORM EDIT --}}
                <form action="{{ route('pemberkasan.update', $pemberkasan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Dropdown Mahasiswa --}}
                    <div class="mb-3">
                        <label for="mahasiswa_id" class="form-label fw-bold">Mahasiswa <span class="text-danger">*</span></label>
                        <select class="form-select @error('mahasiswa_id') is-invalid @enderror" id="mahasiswa_id" name="mahasiswa_id" required>
                            <option value="" disabled>-- Pilih Mahasiswa --</option>
                            @foreach ($mahasiswas as $mhs)
                                <option value="{{ $mhs->id }}" {{ $pemberkasan->mahasiswa_id == $mhs->id ? 'selected' : '' }}>
                                    {{ $mhs->nim }} - {{ $mhs->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('mahasiswa_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>
                    <p class="fw-bold text-muted">Upload Dokumen Baru (PDF only, max 5MB per file)</p>
                    <small class="text-muted">*Kosongkan jika tidak ingin mengganti file.</small>

                    {{-- Form Bimbingan --}}
                    <div class="mb-3">
                        <label for="form_bimbingan" class="form-label">Form Bimbingan</label>
                        @if ($pemberkasan->form_bimbingan)
                            <p class="mb-1"><a href="{{ asset('storage/'.$pemberkasan->form_bimbingan) }}" target="_blank"><i class="fa fa-file-pdf text-danger me-1"></i> Lihat File Lama</a></p>
                        @endif
                        <input class="form-control @error('form_bimbingan') is-invalid @enderror" type="file" id="form_bimbingan" name="form_bimbingan" accept=".pdf">
                        @error('form_bimbingan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Sertifikat --}}
                    <div class="mb-3">
                        <label for="sertifikat" class="form-label">Sertifikat PKL</label>
                        @if ($pemberkasan->sertifikat)
                            <p class="mb-1"><a href="{{ asset('storage/'.$pemberkasan->sertifikat) }}" target="_blank"><i class="fa fa-file-pdf text-danger me-1"></i> Lihat File Lama</a></p>
                        @endif
                        <input class="form-control @error('sertifikat') is-invalid @enderror" type="file" id="sertifikat" name="sertifikat" accept=".pdf">
                        @error('sertifikat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Laporan Final --}}
                    <div class="mb-4">
                        <label for="laporan_final" class="form-label">Laporan Final</label>
                        @if ($pemberkasan->laporan_final)
                            <p class="mb-1"><a href="{{ asset('storage/'.$pemberkasan->laporan_final) }}" target="_blank"><i class="fa fa-file-pdf text-danger me-1"></i> Lihat File Lama</a></p>
                        @endif
                        <input class="form-control @error('laporan_final') is-invalid @enderror" type="file" id="laporan_final" name="laporan_final" accept=".pdf">
                        @error('laporan_final')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pemberkasan.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="footer">
            <small>&copy; 2025 SIPRAKELRA - Sistem Informasi PKL | Politala</small>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
