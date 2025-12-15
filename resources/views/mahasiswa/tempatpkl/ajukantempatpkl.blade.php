<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Tempat PKL | SIPRAKERLA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        /* ---------- BODY & LAYOUT ---------- */
        body {
            background-color: #e9f2ff;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        /* ---------- NAVBAR ---------- */
        .navbar {
            background-color: #004080;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.15);
        }
        .navbar-brand, .nav-link { color: #fff !important; }

        /* ---------- CARD ---------- */
        .card {
            background-color: rgba(243, 244, 245, 0.35);
            border-radius: 18px;
            border: 1px solid rgba(0, 64, 128, 0.3);
            animation: fadeInUp 0.7s ease forwards;
            transform: translateY(15px);
            opacity: 0;
        }

        /* ---------- BUTTONS ---------- */
        .btn-secondary {
            background-color: #004080;
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }
        .btn-secondary:hover {
            background-color: #003366;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(0,0,0,0.25);
        }

        /* ---------- ANIMATIONS ---------- */
        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* ---------- FOOTER ---------- */
        .footer {
            background-color: #004080;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        /* ---------- STEPPER ---------- */
        .stepper-wrapper {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 20px;
        }
        .stepper-step {
            text-align: center;
            position: relative;
            flex: 1;
        }
        .stepper-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 15px;
            right: -50%;
            width: 100%;
            height: 4px;
            background-color: #c0c0c0;
            z-index: 0;
        }
        .stepper-step.completed:not(:last-child)::after {
            background-color: #004080;
        }
        .step-counter {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #c0c0c0;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-weight: bold;
            z-index: 1;
            position: relative;
        }
        .stepper-step.completed .step-counter {
            background-color: #004080;
        }
        .step-name {
            margin-top: 8px;
            font-size: 0.9rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard.mahasiswa') }}">
            <img src="{{ asset('images/Logo_Politala.png') }}" width="40" class="me-2">
            SIPRAKERLA | Mahasiswa
        </a>
        <div class="dropdown ms-auto">
            <a href="#" class="text-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <span class="fw-semibold">{{ Auth::user()->name }}</span> <br>
                <small>Mahasiswa</small>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li><a class="dropdown-item" href="{{ route('mahasiswa.profil') }}"><i class="fas fa-user-edit me-2"></i>Edit Profil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">@csrf
                        <button class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4 mb-4">

    @php
        $status = $pengajuan?->status ?? null;
        $step = 1;
        if($status == 'uploaded' || $status == 'diproses') $step = 2;
        if($status == 'diterima') $step = 3;
    @endphp

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.mahasiswa') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ajukan Tempat PKL</li>
        </ol>
    </nav>

    {{-- STEP PROGRESS BAR MODERN --}}
    <div class="stepper-wrapper mb-4">
        <div class="stepper-step {{ $step >= 1 ? 'completed' : '' }}">
            <div class="step-counter">1</div>
            <div class="step-name">Upload PDF</div>
        </div>
        <div class="stepper-step {{ $step >= 2 ? 'completed' : '' }}">
            <div class="step-counter">2</div>
            <div class="step-name">Validasi Koordinator</div>
        </div>
        <div class="stepper-step {{ $step >= 3 ? 'completed' : '' }}">
            <div class="step-counter">3</div>
            <div class="step-name">Ajukan Tempat PKL</div>
        </div>
    </div>

    <div class="card shadow-sm p-4">

        {{-- ERROR HANDLING --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan!</strong>
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-4">
            <h5>Status Pengajuan:</h5>
            @if(!$status)
                <span class="badge bg-secondary">Belum Upload PDF</span>
            @elseif($status == 'uploaded')
                <span class="badge bg-warning">Sudah Upload PDF - Menunggu Validasi</span>
            @elseif($status == 'diproses')
                <span class="badge bg-info">Sedang Diproses Koordinator PKL</span>
            @elseif($status == 'diterima')
                <span class="badge bg-success">Lolos Validasi - Bisa Ajukan Tempat PKL</span>
            @elseif($status == 'ditolak')
                <span class="badge bg-danger">Tidak Lolos Validasi</span>
            @endif
        </div>

        {{-- STEP 1: UPLOAD PDF --}}
        @if(!$pengajuan || $status == 'ditolak')
        <div class="card mb-4">
            <div class="card-body">
                <form id="pdfUploadForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">Upload Transkrip Nilai (PDF)</label>
                        <input type="file" id="pdf" name="pdf" class="form-control mt-2" accept=".pdf" required>
                    </div>
                    <button type="submit" id="uploadBtn" class="btn btn-danger mt-2">
                        <i class="fa fa-upload"></i> Upload PDF
                    </button>
                </form>
            </div>
        </div>
        @elseif($status == 'uploaded' || $status == 'diproses')
        <div class="alert alert-warning">
            📄 Transkrip sudah di-upload. Sedang menunggu validasi koordinator PKL.</div>
        @endif

        {{-- STEP 2: FORM TEMPAT PKL --}}
        @if($status == 'diterima')
            <form action="{{ route('tempatpkl.store') }}" method="POST">
                @csrf
                <input type="hidden" name="pdf_path" value="{{ $pengajuan->pdf_path }}">

                <div class="row">
                    <h6 class="fw-semibold text-primary mb-3">🏢 Data Tempat PKL</h6>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Perusahaan *</label>
                        <input type="text" name="nama_perusahaan" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bidang Industri *</label>
                        <input type="text" name="bidang" class="form-control" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat *</label>
                        <textarea name="alamat" rows="3" class="form-control" required></textarea>
                    </div>

                    <h6 class="fw-semibold text-success mt-3">📞 Kontak Perusahaan</h6>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama PIC</label>
                        <input type="text" name="nama_pic" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nomor Telepon PIC</label>
                        <input type="text" name="telepon_pic" class="form-control">
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('tempatpkl.lihattempatpkl') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-paper-plane"></i> Ajukan
                    </button>
                </div>

            </form>
        @endif

        <div class="mt-4 d-flex justify-content-start">
            <a href="{{ route('dashboard.mahasiswa') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

    </div>

</main>

<div class="footer">
    <small>&copy; 2025 SIPRAKERLA - Politeknik Negeri Tanah Laut</small>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('pdfUploadForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();

    let fileInput = document.getElementById('pdf');
    let file = fileInput.files[0];

    if (!file) {
        alert("Pilih file PDF terlebih dahulu!");
        return;
    }

    let btn = document.getElementById('uploadBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Uploading...';

    let formData = new FormData();
    formData.append('pdf', file);

    try {
        let res = await fetch(`{{ route('tempatpkl.uploadPdf') }}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData,
            credentials: 'same-origin'
        });

        let data = await res.json();

        if (!res.ok) throw new Error(data.message || 'Upload gagal!');

        alert(data.message);
        location.reload();
    } catch (err) {
        alert("Error: " + err.message);
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-upload"></i> Upload PDF';
    }
});
</script>

</body>
</html>
