<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jadwal Seminar - Koordinator PKL</title>
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
            <a href="{{ route('seminar.index') }}" class="nav-link active"><i class="fa fa-calendar me-2"></i> Kelola Seminar</a>
            <a href="{{ route('penguji.index') }}" class="nav-link"><i class="fa fa-user-check me-2"></i> Kelola Penguji</a>
            <a href="{{ route('datadosen.index') }}" class="nav-link"><i class="fa fa-users me-2"></i> Kelola Data Dosen</a>
            <a href="{{ route('proposal.index') }}" class="nav-link"><i class="fa fa-file-signature me-2"></i> Proposal</a>
            <a href="{{ route('suratpengantar.index') }}" class="nav-link"><i class="fa-solid fa-envelope me-2"></i> Kelola Surat Pengantar</a>
            <a href="{{ route('pemberkasan.index') }}" class="nav-link"><i class="fa-solid fa-folder me-2"></i> Kelola Pemberkasan</a>
        </nav>
    </div>

    <div class="col-10 d-flex flex-column">
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Jadwal Seminar</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Koordinator PKL</small>
            </div>
        </div>

        <div class="container mt-4 flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Detail Seminar: {{ $seminar->nama_mahasiswa }}</h6>
                <div>
                    <a href="{{ route('seminar.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    <a href="{{ route('seminar.edit', $seminar->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
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

        <div class="footer">
            <small>&copy; 2025 SIPRAKELRA - Sistem Informasi PKL | Politala</small>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>