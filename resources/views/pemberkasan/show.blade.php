<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemberkasan - Koordinator PKL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
        .info-label { font-weight: bold; color: #113F67; }
        .file-box { border: 1px solid #ddd; border-radius: 8px; padding: 15px; background: #fff; }
        .file-name { font-style: italic; color: #555; }
    </style>
</head>

<body>
<div class="wrapper">

    {{-- SIDEBAR --}}
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

    {{-- KONTEN UTAMA --}}
    <div class="col-10 d-flex flex-column">
        
        {{-- HEADER --}}
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Pemberkasan Mahasiswa</h5>
            <div class="dropdown text-end">
                <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                    <small>Koordinator PKL</small>
                </a>
                <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit me-2"></i>Edit Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>

        {{-- DETAIL BERKAS --}}
        <div class="container mt-4 flex-grow-1">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Data Pemberkasan</h4>
                    <a href="{{ route('pemberkasan.index') }}" class="btn btn-light">
                        <i class="fa-solid fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>

                <div class="card-body">

                    {{-- INFORMASI MAHASISWA --}}
                    <h5 class="mb-3 text-primary"><i class="fa-solid fa-user-graduate me-2"></i>Informasi Mahasiswa</h5>
                    <div class="row mb-4">
                        <div class="col-md-6"><span class="info-label">Nama:</span> {{ $pemberkasan->mahasiswa->nama ?? '-' }}</div>
                        <div class="col-md-6"><span class="info-label">NIM:</span> {{ $pemberkasan->mahasiswa->nim ?? '-' }}</div>
                        <div class="col-md-6"><span class="info-label">Program Studi:</span> {{ $pemberkasan->mahasiswa->prodi ?? '-' }}</div>
                        <div class="col-md-6"><span class="info-label">Kelas:</span> {{ $pemberkasan->mahasiswa->kelas ?? '-' }}</div>
                        <div class="col-md-6"><span class="info-label">Dosen Pembimbing:</span> {{ $pemberkasan->mahasiswa->dosen_pembimbing ?? '-' }}</div>
                        <div class="col-md-6"><span class="info-label">Tempat PKL:</span> {{ $pemberkasan->mahasiswa->tempat_pkl ?? '-' }}</div>
                    </div>

                    <hr>

                    {{-- FILE BERKAS --}}
                    <h5 class="mb-3 text-primary"><i class="fa-solid fa-folder-open me-2"></i>Berkas Pemberkasan</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="file-box">
                                <h6><i class="fa-solid fa-file-alt me-2"></i>Form Bimbingan</h6>
                                @if($pemberkasan->form_bimbingan_path)
                                    <p class="file-name">{{ basename($pemberkasan->form_bimbingan_path) }}</p>
                                    <a href="{{ asset('storage/' . $pemberkasan->form_bimbingan_path) }}" target="_blank" class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-eye me-1"></i> Lihat File
                                    </a>
                                @else
                                    <span class="badge bg-danger">Belum Diupload</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="file-box">
                                <h6><i class="fa-solid fa-certificate me-2"></i>Sertifikat</h6>
                                @if($pemberkasan->sertifikat_path)
                                    <p class="file-name">{{ basename($pemberkasan->sertifikat_path) }}</p>
                                    <a href="{{ asset('storage/' . $pemberkasan->sertifikat_path) }}" target="_blank" class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-eye me-1"></i> Lihat File
                                    </a>
                                @else
                                    <span class="badge bg-danger">Belum Diupload</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="file-box">
                                <h6><i class="fa-solid fa-book me-2"></i>Laporan Final</h6>
                                @if($pemberkasan->laporan_final_path)
                                    <p class="file-name">{{ basename($pemberkasan->laporan_final_path) }}</p>
                                    <a href="{{ asset('storage/' . $pemberkasan->laporan_final_path) }}" target="_blank" class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-eye me-1"></i> Lihat File
                                    </a>
                                @else
                                    <span class="badge bg-danger">Belum Diupload</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- STATUS --}}
                    <div class="mb-3">
                        <h6><i class="fa-solid fa-check-circle me-2"></i>Status Pemberkasan:</h6>
                        <span class="badge bg-{{ $pemberkasan->is_lengkap ? 'primary' : 'warning text-dark' }}">
                            {{ $pemberkasan->is_lengkap ? 'Lengkap' : 'Belum Lengkap' }}
                        </span>
                    </div>

                    <hr>

                    {{-- AKSI --}}
                    <div class="text-end">
                        <a href="{{ route('pemberkasan.edit', $pemberkasan->id) }}" class="btn btn-warning">
                            <i class="fa-solid fa-pen me-1"></i> Edit Data
                        </a>
                        <form action="{{ route('pemberkasan.destroy', $pemberkasan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini? Semua file terkait akan dihapus.');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">
                                <i class="fa-solid fa-trash me-1"></i> Hapus
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="footer">
            <small>&copy; 2025 SIPRAKELRA - Sistem Informasi PKL | Politala</small>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
