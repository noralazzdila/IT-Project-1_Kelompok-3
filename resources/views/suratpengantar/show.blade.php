<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Surat Pengantar - Koordinator PKL</title>
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
        .detail-label {
            font-weight: 600;
            color: #6c757d;
        }
    </style>
</head>
<body>
<div class="wrapper">
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
            <a href="{{ route('tempatpkl.index') }}" class="nav-link"><i class="fa fa-building me-2"></iTempat PKL</a>
            <a href="{{ route('datamahasiswa.index') }}" class="nav-link"><i class="fa fa-id-card me-2"></i> Kelola Data Mahasiswa</a>
            <a href="{{ route('bimbingan.index') }}" class="nav-link"><i class="fa fa-chalkboard-teacher me-2"></i> Kelola Bimbingan</a>
            <a href="{{ route('seminar.index') }}" class="nav-link"><i class="fa fa-calendar me-2"></i> Kelola Seminar</a>
            <a href="{{ route('penguji.index') }}" class="nav-link"><i class="fa fa-user-check me-2"></i> Kelola Penguji</a>
            <a href="{{ route('datadosen.index') }}" class="nav-link"><i class="fa fa-users me-2"></i> Kelola Data Dosen</a>
            <a href="{{ route('proposal.index') }}" class="nav-link"><i class="fa fa-file-signature me-2"></i> Proposal</a>
            <a href="{{ route('suratpengantar.index') }}" class="nav-link active"><i class="fa-solid fa-envelope me-2"></i> Kelola Surat Pengantar</a>
            <a href="{{ route('pemberkasan.index') }}" class="nav-link"><i class="fa-solid fa-folder me-2"></i> Kelola Pemberkasan</a>
        </nav>
    </div>

    <div class="col-10 d-flex flex-column">
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Surat Pengantar</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Koordinator PKL</small>
            </div>
        </div>

        <div class="container mt-4 flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Detail Surat: {{ $suratpengantar->nama_mahasiswa }}</h6>
                <a href="{{ route('suratpengantar.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card shadow-sm p-4">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <p class="detail-label mb-1">NIM / Nama</p>
                        <h5>{{ $suratpengantar->nim }} / {{ $suratpengantar->nama_mahasiswa }}</h5>
                    </div>
                    <div class="col-md-4">
                        <p class="detail-label mb-1">Program Studi</p>
                        <h5>{{ $suratpengantar->prodi }}</h5>
                    </div>
                     <div class="col-md-4">
                        <p class="detail-label mb-1">Tanggal Pengajuan</p>
                        <h5>{{ \Carbon\Carbon::parse($suratpengantar->tanggal_pengajuan)->translatedFormat('d F Y') }}</h5>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p class="detail-label mb-1">Tempat PKL</p>
                        <p>{{ $suratpengantar->tempat_pkl }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="detail-label mb-1">Alamat Perusahaan</p>
                        <p>{{ $suratpengantar->alamat_perusahaan }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="detail-label mb-1">Status</p>
                        @php
                            $badgeClass = match($suratpengantar->status) {
                                'Menunggu' => 'bg-warning text-dark',
                                'Diproses' => 'bg-primary',
                                'Selesai' => 'bg-success',
                                default => 'bg-secondary',
                            };
                        @endphp
                        <p><span class="badge fs-6 {{ $badgeClass }}">{{ $suratpengantar->status }}</span></p>
                    </div>
                     <div class="col-md-6 mb-3">
                        <p class="detail-label mb-1">File Surat</p>
                        @if ($suratpengantar->file_surat)
                            <a href="{{ asset('storage/' . $suratpengantar->file_surat) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-download"></i> Unduh File
                            </a>
                        @else
                            <span class="text-muted">File belum diunggah.</span>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <p class="detail-label mb-1">Catatan</p>
                        <div class="p-3 bg-light rounded border">
                            {!! nl2br(e($suratpengantar->catatan ?? 'Tidak ada catatan.')) !!}
                        </div>
                    </div>
                </div>

                @if ($suratpengantar->file_surat && Storage::exists('public/' . $suratpengantar->file_surat))
                <div class="mt-4">
                    <h6 class="mb-3">Preview File Surat</h6>
                    <iframe src="{{ asset('storage/' . $suratpengantar->file_surat) }}" width="100%" height="600px" class="border rounded"></iframe>
                </div>
                @endif
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
