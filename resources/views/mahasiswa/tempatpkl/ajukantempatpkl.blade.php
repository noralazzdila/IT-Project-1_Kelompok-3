<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Tempat PKL | SIPRAKERLA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            background-color: rgba(255, 255, 255, 0.9); /* Sedikit lebih putih agar teks terbaca */
            border-radius: 18px;
            border: 1px solid rgba(0, 64, 128, 0.1);
            animation: fadeInUp 0.7s ease forwards;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        /* ---------- BUTTONS ---------- */
        .btn-primary {
            background-color: #004080;
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #003366;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(0,0,0,0.25);
        }
        
        .btn-secondary {
            border-radius: 10px;
            font-weight: 600;
        }

        /* ---------- ANIMATIONS ---------- */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ---------- FOOTER ---------- */
        .footer {
            background-color: #004080;
            color: #fff;
            text-align: center;
            padding: 10px;
            margin-top: auto;
        }

        /* ---------- STEPPER ---------- */
        .stepper-wrapper {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 30px;
            margin-top: 10px;
        }
        .stepper-step {
            text-align: center;
            position: relative;
            flex: 1;
            z-index: 2;
        }
        /* Garis Penghubung */
        .stepper-wrapper::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 15%; /* Mulai sedikit ke dalam */
            right: 15%; /* Berakhir sedikit ke dalam */
            height: 4px;
            background-color: #c0c0c0;
            z-index: 1;
        }
        /* Garis Progress (Warna Biru) */
        .stepper-progress {
            position: absolute;
            top: 15px;
            left: 15%;
            height: 4px;
            background-color: #004080;
            z-index: 1;
            transition: width 0.5s ease;
        }

        .step-counter {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #fff;
            border: 3px solid #c0c0c0;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            color: #c0c0c0;
            font-weight: bold;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        /* State: Completed / Active */
        .stepper-step.active .step-counter,
        .stepper-step.completed .step-counter {
            border-color: #004080;
            background-color: #004080;
            color: #fff;
        }
        
        .step-name {
            margin-top: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #6c757d;
        }
        .stepper-step.active .step-name,
        .stepper-step.completed .step-name {
            color: #004080;
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard.mahasiswa') }}">
            {{-- Ganti src sesuai path logo Anda --}}
            {{-- <img src="{{ asset('images/Logo_Politala.png') }}" width="40" class="me-2"> --}}
            <i class="fas fa-university me-2"></i>
            SIPRAKERLA | Mahasiswa
        </a>
        <div class="dropdown ms-auto">
            <a href="#" class="text-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <span class="fw-semibold">{{ Auth::user()->name }}</span> <br>
                <small style="font-size: 0.8em; opacity: 0.8;">Mahasiswa</small>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
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

<main class="container mt-4 mb-5">

    {{-- LOGIC PHP UNTUK MENENTUKAN STEP --}}
    @php
        $status = $pengajuan?->status ?? null; // Reintroduce $status
        $hasNilai = isset($nilai) && !empty($nilai->id);
        $hasUploadedTranscript = $pengajuan && $pengajuan->pdf_path;
        
        $currentStep = 1; // Default: Upload Transkrip
        $progressWidth = '0%';

        if ($hasUploadedTranscript && $isEligible) {
            $currentStep = 2; // Eligible, ready to input PKL data (form untuk surat pengantar)
            $progressWidth = '33%';
            if ($pengajuan && $pengajuan->status == 'surat_diajukan') { // Jika surat pengantar sudah diajukan
                $currentStep = 3; // Surat pengantar diajukan, menunggu verifikasi koordinator
                $progressWidth = '66%';
            }
            // If application has moved past initial state and not rejected
            // and status is not 'surat_diajukan' (meaning it's being processed by coordinator)
            if ($pengajuan && $pengajuan->status == 'diproses') {
                $currentStep = 3; // Input data PKL submitted, awaiting coordinator
                $progressWidth = '66%';
            }
            if (in_array($pengajuan->status, ['diterima', 'ditolak'])) { // Final status
                $currentStep = 4; // This step is not in the stepper, but indicates completion
                $progressWidth = '100%';
            }
        }
    @endphp

    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.mahasiswa') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">Ajukan Tempat PKL</li>
        </ol>
    </nav>

    {{-- STEP PROGRESS BAR --}}
    <div class="stepper-wrapper">
        <div class="stepper-progress" style="width: {{ $progressWidth }}"></div>
        
        <div class="stepper-step {{ $currentStep >= 1 ? 'completed' : '' }}">
            <div class="step-counter">1</div>
            <div class="step-name">Upload Transkrip</div>
        </div>
        <div class="stepper-step {{ $currentStep >= 2 ? 'completed' : '' }}">
            <div class="step-counter">2</div>
            <div class="step-name">Input Data PKL</div>
        </div>
        <div class="stepper-step {{ $currentStep >= 3 ? 'completed' : '' }}">
            <div class="step-counter">3</div>
            <div class="step-name">Verifikasi Koordinator</div>
        </div>
    </div>

    {{-- MAIN CARD --}}
    <div class="card shadow-sm p-4">

        {{-- GLOBAL ALERTS --}}
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm">
                <strong><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan!</strong>
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        {{-- STATUS BADGE --}}
        <div class="mb-4 pb-2 border-bottom">
            <h5 class="fw-bold mb-2">Status Saat Ini:</h5>
            @if(!$pengajuan)
                <span class="badge bg-secondary p-2"><i class="fas fa-circle me-2"></i>Belum Mengajukan</span>
            @elseif($pengajuan->status == 'belum_diajukan')
                <span class="badge bg-secondary p-2"><i class="fas fa-file-alt me-2"></i>Menunggu Pengajuan Tempat PKL</span>
            @elseif($pengajuan->status == 'diproses')
                <span class="badge bg-warning text-dark p-2"><i class="fas fa-clock me-2"></i>Menunggu Verifikasi Koordinator</span>
            @elseif($pengajuan->status == 'diterima')
                <span class="badge bg-success p-2"><i class="fas fa-check-double me-2"></i>Pengajuan Disetujui</span>
            @elseif($pengajuan->status == 'ditolak')
                <span class="badge bg-danger p-2"><i class="fas fa-times-circle me-2"></i>Pengajuan Ditolak</span>
            @elseif($pengajuan->status == 'diajukan')
                <span class="badge bg-primary p-2"><i class="fas fa-paper-plane me-2"></i>Tempat PKL Diajukan</span>
            @elseif($pengajuan->status == 'surat_diajukan')
                <span class="badge bg-info p-2"><i class="fas fa-envelope me-2"></i>Surat Pengantar Diajukan</span>
            @endif
        </div>


        {{-- ========================================================== --}}
        {{-- SECTION 1: UPLOAD TRANSKRIP & ELIGIBILITY CHECK            --}}
        {{-- Display if no transcript uploaded OR not eligible OR rejected --}}
        {{-- ========================================================== --}}
        @if(!$hasUploadedTranscript || !$isEligible || ($pengajuan && $pengajuan->status == 'ditolak'))
        
            <div class="row">
                <div class="col-md-7">
                    <h5 class="fw-bold text-primary mb-3"><i class="fas fa-file-upload me-2"></i>Form Upload Transkrip</h5>
                    
                    @if($pengajuan && $pengajuan->status == 'ditolak')
                        <div class="alert alert-danger">
                            <strong><i class="fas fa-times-circle"></i> Pengajuan Ditolak!</strong><br>
                            Catatan: <em>{{ $pengajuan->catatan ?? 'Tidak ada catatan.' }}</em><br>
                            Silakan perbaiki transkrip dan upload ulang.
                        </div>
                    @endif

                    <form id="pdfUploadForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">File Transkrip Nilai (PDF)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-file-pdf text-danger"></i></span>
                                <input type="file" id="pdf" name="pdf" class="form-control" accept=".pdf" required>
                            </div>
                            <div class="form-text">Maksimal ukuran file 2MB. Pastikan file dapat dibaca.</div>
                        </div>
                        <button type="submit" id="uploadBtn" class="btn btn-primary w-100 py-2">
                            <i class="fa fa-upload me-2"></i> Validasi Otomatis & Upload
                        </button>
                    </form>
                </div>

                {{-- Tabel Syarat (Opsional, untuk info) --}}
                <div class="col-md-5 mt-4 mt-md-0">
                    <div class="bg-light p-3 rounded-3 border">
                        <h6 class="fw-bold mb-3"><i class="fas fa-list-check me-2"></i>Syarat Pengajuan Perusahaan</h6>
                        <ul class="list-group list-group-flush small bg-transparent">
                            <li class="list-group-item bg-transparent d-flex justify-content-between">
                                <span>Min. SKS Lulus</span> <span class="fw-bold">77 SKS</span>
                            </li>
                            <li class="list-group-item bg-transparent d-flex justify-content-between">
                                <span>Min. IPK</span> <span class="fw-bold">2.50</span>
                            </li>
                            <li class="list-group-item bg-transparent d-flex justify-content-between">
                                <span>Maks. Nilai D</span> <span class="fw-bold">6 SKS</span>
                            </li>
                            <li class="list-group-item bg-transparent d-flex justify-content-between">
                                <span>Nilai E</span> <span class="fw-bold text-danger">0 (Tidak Boleh)</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


        {{-- ========================================================== --}}
        {{-- SECTION 3: MENUNGGU VERIFIKASI KOORDINATOR                 --}}
        {{-- Display if eligible and application submitted, awaiting review --}}
        {{-- ========================================================== --}}
        @elseif($hasUploadedTranscript && $isEligible && $pengajuan?->status == 'diproses')

    <div class="text-center py-5">
        <div class="mb-3">
            <i class="fas fa-clock fa-4x text-warning fa-beat-fade" style="--fa-animation-duration: 2s;"></i>
        </div>
        <h3 class="fw-bold text-dark">Menunggu Validasi Koordinator</h3>
        <p class="text-muted col-md-8 mx-auto">
            Transkrip Anda telah berhasil diunggah pada <strong>{{ $pengajuan->created_at->format('d M Y, H:i') }}</strong>.
            <br>Koordinator PKL sedang memeriksa kelengkapan berkas Anda.
        </p>
        
        <div class="mt-4 d-flex justify-content-center gap-2">
            {{-- Tombol Lihat File --}}
            <a href="{{ asset('storage/' . $pengajuan->pdf_path) }}" target="_blank" class="btn btn-outline-primary">
                <i class="fas fa-file-pdf me-2"></i>Cek File Anda
            </a>

            {{-- Tombol BATAL / RESET (Hanya muncul jika belum diproses koordinator) --}}
            @if($pengajuan && $pengajuan->status == 'belum_diajukan')
                <form action="{{ route('tempatpkl.reset') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan upload ini? Anda harus mengupload ulang transkrip.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-trash-alt me-2"></i>Batal & Upload Ulang
                    </button>
                </form>
            @endif
        </div>

        @if($pengajuan && $pengajuan->status == 'diproses')
            <div class="alert alert-info mt-4 d-inline-block">
                <small><i class="fas fa-info-circle me-1"></i> Berkas sedang ditinjau Koordinator. Anda tidak bisa membatalkan saat ini.</small>
            </div>
        @endif
    </div>

        {{-- ========================================================== --}}
        {{-- SECTION 2: FORM INPUT DATA SURAT PENGANTAR PKL (Jika Eligible & status belum diajukan) --}}
        {{-- ========================================================== --}}
        @elseif($hasUploadedTranscript && $isEligible && $pengajuan?->status == 'belum_diajukan')
        
            <form action="{{ route('mahasiswa.tempatpkl.store') }}" method="POST">
                @csrf
                
                {{-- PERBAIKAN 1: Tambahkan ID Mahasiswa (Hidden) --}}
                <input type="hidden" name="mahasiswa_id" value="{{ Auth::user()->mahasiswa->id ?? Auth::id() }}">

                {{-- Input Hidden lain yang sudah ada --}}
                <input type="hidden" name="pdf_path" value="{{ $pengajuan->pdf_path }}">

                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x me-3"></i>
                            <div>
                                <strong>Validasi Berhasil!</strong><br>
                                Transkrip Anda memenuhi syarat. Silakan lengkapi data tempat PKL untuk pengajuan surat pengantar.
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-building me-2"></i>Data Tempat PKL untuk Surat Pengantar</h6>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">Nama Perusahaan / Instansi <span class="text-danger">*</span></label>
                        <input type="text" name="nama_perusahaan" class="form-control" placeholder="Contoh: PT. Telkom Indonesia" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">Alamat Lengkap Perusahaan <span class="text-danger">*</span></label>
                        <textarea name="alamat" rows="3" class="form-control" placeholder="Alamat lengkap perusahaan beserta kota/kabupaten" required></textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="fa fa-envelope me-2"></i> Ajukan Surat Pengantar PKL
                    </button>
                </div>
            </form>

        {{-- ========================================================== --}}
        {{-- SECTION 4: APLIKASI DISETUJUI / DITOLAK / DIAJUKAN         --}}
        {{-- ========================================================== --}}
        @elseif($hasUploadedTranscript && $isEligible && in_array($pengajuan->status, ['diterima', 'ditolak', 'diajukan']))
            @if($pengajuan->status == 'diterima')
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-check-circle fa-4x text-success"></i>
                    </div>
                    <h3 class="fw-bold">Pengajuan Disetujui!</h3>
                    <p class="text-muted col-md-8 mx-auto">
                        Pengajuan tempat PKL Anda di <strong>{{ $pengajuan->nama_perusahaan }}</strong> telah <span class="fw-bold text-success">disetujui</span> oleh Koordinator.<br>
                        Selanjutnya Anda akan diarahkan untuk proses administrasi surat pengantar.
                    </p>
                    @if($pengajuan?->pdf_path)
                    <div class="mt-4">
                        <a href="{{ asset('storage/' . $pengajuan->pdf_path) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-file-pdf me-2"></i>Cek Transkrip Anda
                        </a>
                    </div>
                    @endif
                </div>
            @elseif($pengajuan->status == 'ditolak')
                <div class="alert alert-danger text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-times-circle fa-4x"></i>
                    </div>
                    <h3 class="fw-bold">Pengajuan Ditolak!</h3>
                    <p class="text-muted col-md-8 mx-auto">
                        Pengajuan tempat PKL Anda di <strong>{{ $pengajuan->nama_perusahaan }}</strong> telah <span class="fw-bold text-danger">ditolak</span> oleh Koordinator.<br>
                        Catatan: <em>{{ $pengajuan->catatan ?? 'Tidak ada catatan.' }}</em><br>
                        Silakan kembali ke awal untuk mengulang proses pengajuan.
                    </p>
                    @if($pengajuan?->pdf_path)
                    <div class="mt-4">
                        <a href="{{ asset('storage/' . $pengajuan->pdf_path) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-file-pdf me-2"></i>Cek Transkrip Anda
                        </a>
                    </div>
                    @endif
                </div>
            @elseif($pengajuan->status == 'diajukan')
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-check-circle fa-4x text-success"></i>
                    </div>
                    <h3 class="fw-bold">Pengajuan Berhasil Dikirim!</h3>
                    <p class="text-muted">
                        Data tempat PKL Anda di <strong>{{ $pengajuan->nama_perusahaan }}</strong> telah tersimpan.<br>
                        Silakan menunggu proses administrasi Surat Pengantar.
                    </p>
                    @if($pengajuan?->pdf_path)
                    <div class="mt-4">
                        <a href="{{ asset('storage/' . $pengajuan->pdf_path) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-file-pdf me-2"></i>Cek Transkrip Anda
                        </a>
                    </div>
                    @endif
                </div>
            @elseif($pengajuan->status == 'surat_diajukan')
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-envelope-open-text fa-4x text-info"></i>
                    </div>
                    <h3 class="fw-bold">Surat Pengantar Diajukan!</h3>
                    <p class="text-muted col-md-8 mx-auto">
                        Pengajuan surat pengantar PKL Anda untuk <strong>{{ $pengajuan->nama_perusahaan }}</strong> telah berhasil dikirim.<br>
                        Silakan menunggu verifikasi dari Koordinator PKL.
                    </p>
                    @if($pengajuan?->pdf_path)
                    <div class="mt-4">
                        <a href="{{ asset('storage/' . $pengajuan->pdf_path) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-file-pdf me-2"></i>Cek Transkrip Anda
                        </a>
                    </div>
                    @endif
                </div>
            @endif
        @else
            {{-- Fallback: Should not happen if logic is correct --}}
            <div class="alert alert-info text-center">
                <strong>Informasi:</strong> Status pengajuan tidak dikenal atau belum ada proses.
            </div>
        @endif

        {{-- TOMBOL KEMBALI GLOBAL (Kecuali jika sudah di step akhir) --}}
        @if($currentStep != 4)
            <div class="mt-4 pt-3 border-top d-flex justify-content-start">
                <a href="{{ route('dashboard.mahasiswa') }}" class="btn btn-light text-muted border">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
        @endif

    </div>

</main>

<div class="footer">
    <small>&copy; {{ date('Y') }} SIPRAKERLA - Politeknik Negeri Tanah Laut</small>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- SCRIPT UPLOAD PDF --}}
@php
echo "<script>
document.getElementById('pdfUploadForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();

    let fileInput = document.getElementById('pdf');
    let file = fileInput.files[0];

    if (!file) {
        alert('Pilih file PDF terlebih dahulu!');
        return;
    }

    let btn = document.getElementById('uploadBtn');
    let originalText = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<span class=\"spinner-border spinner-border-sm me-2\"></span>Sedang Mengupload...';

    let formData = new FormData();
    formData.append('pdf', file);

    try {
        let res = await fetch(`" . route('tempatpkl.uploadPdf') . "`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content },
            body: formData
        });

        let data = await res.json();

        if (!res.ok) {
            // If validation failed or other server error, show message
            let errorMessage = data.message || 'Upload gagal!';
            
            // Handle eligibility failure specifically
            if (data.isEligible === false) {
                alert('Validasi Gagal: ' + errorMessage);
                location.reload(); // Reload to show eligibility message in the PHP section
            } else {
                alert('Gagal: ' + errorMessage);
            }
            throw new Error(errorMessage); // Propagate error for catch block
        }

        // Tampilkan sukses
        alert('Berhasil! Transkrip diupload dan divalidasi.');
        location.reload(); // Reload untuk memperbarui tampilan ke Step 2 (Form input tempat PKL)

    } catch (err) {
        // Error from fetch or from non-2xx response
        alert('Gagal: ' + err.message);
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
});
</script>";
@endphp

</body>
</html>