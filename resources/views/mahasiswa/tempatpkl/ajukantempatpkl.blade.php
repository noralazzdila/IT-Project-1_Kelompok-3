<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Tempat PKL | SIPRAKERLA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #e9f2ff; font-family: 'Segoe UI', sans-serif; display: flex; flex-direction: column; min-height: 100vh; }
        main { flex: 1; }
        .navbar { background-color: #004080; box-shadow: 0 3px 12px rgba(0,0,0,0.15); }
        .navbar-brand, .nav-link { color: #fff !important; }
        .card { background-color: #fff; border-radius: 18px; border: 1px solid rgba(0,64,128,0.1); }
        .btn-primary { background-color: #004080; border:none; }
        .btn-primary:hover { background-color: #003366; }
        .footer { background-color: #004080; color: #fff; text-align: center; padding: 10px; }
        .stepper-wrapper { display: flex; justify-content: space-between; position: relative; margin-bottom: 20px; }
        .stepper-step { text-align: center; position: relative; flex: 1; }
        .stepper-step::after { content: ''; position: absolute; top: 15px; right: -50%; width: 100%; height: 4px; background-color: #dcdcdc; z-index: 0; }
        .stepper-step:last-child::after { content: none; }
        .stepper-step.completed::after { background-color: #004080; }
        .step-counter { width: 30px; height: 30px; border-radius: 50%; background-color: #dcdcdc; display: inline-flex; justify-content: center; align-items: center; color: #fff; font-weight: bold; z-index: 1; position: relative; }
        .stepper-step.completed .step-counter { background-color: #004080; }
        .step-name { margin-top: 8px; font-size: 0.9rem; font-weight: 500; }
        .requirement-list li { display: flex; justify-content: space-between; align-items: center; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard.mahasiswa') }}">
            <img src="{{ asset('images/Logo_Politala.png') }}" width="40" class="me-2"> SIPRAKERLA
        </a>
        <div class="dropdown ms-auto">
            <a href="#" class="text-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <span class="fw-semibold">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li><a class="dropdown-item" href="{{ route('mahasiswa.profil') }}"><i class="fas fa-user-edit me-2"></i>Edit Profil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><form action="{{ route('logout') }}" method="POST">@csrf<button class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button></form></li>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4 mb-4">
    @php
        $status = $pengajuan->status ?? null;
        $step = 1;
        if ($status === 'diterima' || $status === 'diproses') $step = 2;
        if ($status === 'selesai') $step = 3; // Misal ada status 'selesai'
    @endphp

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.mahasiswa') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ajukan Tempat PKL</li>
        </ol>
    </nav>

    <div class="stepper-wrapper mb-4">
        <div class="stepper-step {{ $step >= 1 ? 'completed' : '' }}">
            <div class="step-counter">1</div>
            <div class="step-name">Validasi Nilai</div>
        </div>
        <div class="stepper-step {{ $step >= 2 ? 'completed' : '' }}">
            <div class="step-counter">2</div>
            <div class="step-name">Input Tempat PKL</div>
        </div>
        <div class="stepper-step {{ $step >= 3 ? 'completed' : '' }}">
            <div class="step-counter">3</div>
            <div class="step-name">Selesai</div>
        </div>
    </div>

    <div class="card shadow-sm p-4">

        <div id="alert-container"></div>

        <div class="mb-4">
            <h5 class="mb-3">Status Pengajuan:</h5>
            @if(!$status) <span class="badge bg-secondary fs-6">1. Belum Validasi Nilai</span>
            @elseif($status == 'ditolak') <span class="badge bg-danger fs-6">1. Gagal Validasi Nilai</span>
            @elseif($status == 'diterima') <span class="badge bg-success fs-6">2. Lolos Validasi - Silakan Ajukan Tempat PKL</span>
            @elseif($status == 'diproses') <span class="badge bg-info fs-6">2. Pengajuan Tempat PKL Sedang Diproses</span>
            @endif
        </div>

        {{-- STEP 1: UPLOAD & VALIDASI PDF --}}
        @if(!$status || $status == 'ditolak')
        <div class="card mb-4 border-2 {{ $status == 'ditolak' ? 'border-danger' : 'border-primary' }}">
            <div class="card-header fw-bold">{{ $status == 'ditolak' ? 'Unggah Ulang Transkrip Nilai' : 'Langkah 1: Validasi Transkrip Nilai' }}</div>
            <div class="card-body">
                <p>Silakan unggah transkrip nilai terakhir Anda dalam format PDF. Sistem akan memvalidasi secara otomatis apakah Anda memenuhi syarat untuk PKL.</p>
                <form id="pdfUploadForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="pdf" class="form-label">File Transkrip Nilai (PDF)</label>
                        <input type="file" id="pdf" name="pdf" class="form-control" accept=".pdf" required>
                    </div>
                    <button type="submit" id="uploadBtn" class="btn btn-primary">
                        <i class="fa fa-upload"></i> Unggah & Validasi
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- Syarat PKL --}}
        @if($requirements)
        <div class="card mb-4">
            <div class="card-header fw-bold">Syarat Pengajuan PKL</div>
            <div class="card-body">
                <ul class="list-group list-group-flush requirement-list">
                    @foreach($requirements as $key => $req)
                    <li class="list-group-item">
                        <span>{{ $key }}</span>
                        @if($status == 'ditolak')
                            <span class="badge {{ $req['status'] ? 'bg-success' : 'bg-danger' }}">
                                Syarat: {{ $req['required'] }} | Anda: {{ $req['actual'] }}
                                <i class="fa {{ $req['status'] ? 'fa-check-circle' : 'fa-times-circle' }} ms-1"></i>
                            </span>
                        @else
                             <span class="badge bg-secondary">{{ $req['required'] }}</span>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        {{-- STEP 2: FORM TEMPAT PKL (hanya tampil jika status diterima) --}}
        @if($status == 'diterima' || $status == 'diproses')
        <div class="card border-2 border-success">
            <div class="card-header fw-bold">Langkah 2: Ajukan Tempat PKL</div>
            <div class="card-body">
                 @if($status == 'diproses')
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle me-2"></i>
                        Pengajuan Anda untuk <strong>{{ $pengajuan->nama_perusahaan }}</strong> sedang diproses oleh Koordinator PKL. Mohon ditunggu.
                    </div>
                @else
                <form action="{{ route('tempatpkl.store') }}" method="POST">
                    @csrf
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
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Ajukan</button>
                    </div>
                </form>
                @endif
            </div>
        </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('dashboard.mahasiswa') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</main>

<footer class="footer mt-auto">
    <small>&copy; {{ date('Y') }} SIPRAKERLA - Politeknik Negeri Tanah Laut</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('pdfUploadForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();

    const fileInput = document.getElementById('pdf');
    if (!fileInput.files.length) {
        showAlert('Pilih file PDF terlebih dahulu!', 'warning');
        return;
    }

    const btn = document.getElementById('uploadBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengunggah & Memvalidasi...';
    
    const alertContainer = document.getElementById('alert-container');
    alertContainer.innerHTML = '';

    const formData = new FormData();
    formData.append('pdf', fileInput.files[0]);
    formData.append('_token', '{{ csrf_token() }}');

    try {
        const response = await fetch(`{{ route('tempatpkl.uploadPdf') }}`, {
            method: 'POST',
            body: formData,
            headers: { 'Accept': 'application/json' },
        });

        const data = await response.json();

        if (!response.ok) {
           throw new Error(data.message || `Error ${response.status}`);
        }
        
        showAlert(data.message, 'success');
        setTimeout(() => location.reload(), 2000);

    } catch (error) {
        showAlert(error.message, 'danger');
        setTimeout(() => location.reload(), 4000); // Reload on error to show requirement details
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-upload"></i> Unggah & Validasi';
    }
});

function showAlert(message, type) {
    const alertContainer = document.getElementById('alert-container');
    const alert = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
    alertContainer.innerHTML = alert;
}
</script>

</body>
</html>

