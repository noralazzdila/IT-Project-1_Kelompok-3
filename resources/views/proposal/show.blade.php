<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Proposal PKL - Koordinator PKL</title>
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
            <a href="{{ route('user.index') }}" class="nav-link"><i class="fa fa-users me-2"></i> Kelola User</a>
            <a href="{{ route('nilai.index') }}" class="nav-link"><i class="fa fa-graduation-cap me-2"></i> Kelola Nilai</a>
            <a href="{{ route('tempatpkl.index') }}" class="nav-link"><i class="fa fa-building me-2"></i> Kelola Tempat PKL</a>
            <a href="{{ route('datamahasiswa.index') }}" class="nav-link"><i class="fa fa-id-card me-2"></i> Kelola Data Mahasiswa</a>
            <a href="{{ route('bimbingan.index') }}" class="nav-link"><i class="fa fa-chalkboard-teacher me-2"></i> Kelola Bimbingan</a>
            <a href="{{ route('seminar.index') }}" class="nav-link"><i class="fa fa-calendar me-2"></i> Kelola Seminar</a>
            <a href="{{ route('penguji.index') }}" class="nav-link"><i class="fa fa-user-check me-2"></i> Kelola Penguji</a>
            <a href="{{ route('datadosen.index') }}" class="nav-link"><i class="fa fa-users me-2"></i> Kelola Data Dosen</a>
            <a href="{{ route('proposal.index') }}" class="nav-link active"><i class="fa fa-file-signature me-2"></i> Proposal</a>
            <a href="{{ route('suratpengantar.index') }}" class="nav-link"><i class="fa-solid fa-envelope me-2"></i> Kelola Surat Pengantar</a>
            <a href="{{ route('pemberkasan.index') }}" class="nav-link"><i class="fa-solid fa-folder me-2"></i> Kelola Pemberkasan</a>
        </nav>
    </div>

    <div class="col-10 d-flex flex-column">
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Proposal PKL</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Koordinator PKL</small>
            </div>
        </div>

        <div class="container mt-4 flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Detail Proposal: {{ $proposal->nama_mahasiswa }}</h6>
                <a href="{{ route('proposal.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>

            <div class="card shadow-sm p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p class="detail-label mb-1">NIM</p>
                        <p class="fs-5">{{ $proposal->nim }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="detail-label mb-1">Nama Mahasiswa</p>
                        <p class="fs-5">{{ $proposal->nama_mahasiswa }}</p>
                    </div>
                    <div class="col-md-12 mb-3">
                         <p class="detail-label mb-1">Judul Proposal</p>
                        <p class="fs-5">{{ $proposal->judul_proposal }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="detail-label mb-1">Dosen Pembimbing</p>
                        <p>{{ $proposal->pembimbing }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="detail-label mb-1">Tempat PKL</p>
                        <p>{{ $proposal->tempat_pkl }}</p>
                    </div>
                    <hr>
                    <div class="col-md-4 mb-3">
                        <p class="detail-label mb-1">Tanggal Pengajuan</p>
                        <p>{{ \Carbon\Carbon::parse($proposal->tanggal_pengajuan)->translatedFormat('d F Y') }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <p class="detail-label mb-1">Status</p>
                        @php
                            $badgeClass = '';
                            if ($proposal->status == 'Menunggu') $badgeClass = 'bg-warning text-dark';
                            elseif ($proposal->status == 'Disetujui') $badgeClass = 'bg-success';
                            elseif ($proposal->status == 'Ditolak') $badgeClass = 'bg-danger';
                        @endphp
                        <p><span class="badge fs-6 {{ $badgeClass }}">{{ $proposal->status }}</span></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <p class="detail-label mb-1">File Proposal</p>
                        <a href="{{ asset('storage/' . $proposal->file_proposal) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-download"></i> Unduh File
                        </a>
                    </div>
                    <div class="col-md-12 mb-3">
                        <p class="detail-label mb-1">Catatan</p>
                        <div class="p-3 bg-light rounded border">
                            {!! nl2br(e($proposal->catatan ?? 'Tidak ada catatan.')) !!}
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6 class="mb-3">Preview File Proposal</h6>
                     @if($proposal->file_proposal && Storage::exists('public/' . $proposal->file_proposal))
                        <iframe src="{{ asset('storage/' . $proposal->file_proposal) }}" width="100%" height="600px" class="border rounded"></iframe>
                    @else
                        <div class="alert alert-warning">File tidak ditemukan.</div>
                    @endif
                </div>
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