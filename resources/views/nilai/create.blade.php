@extends('layouts.app')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Nilai - Koordinator PKL</title>
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
                <a href="{{ route('user.index') }}" class="nav-link"><i class="fa fa-users me-2"></i>User</a>
                <a href="{{ route('nilai.index') }}" class="nav-link active"><i class="fa fa-graduation-cap me-2"></i>Nilai</a>
                <a href="{{ route('tempatpkl.index') }}" class="nav-link"><i class="fa fa-building me-2"></i>Tempat PKL</a>
                <a href="{{ route('datamahasiswa.index') }}" class="nav-link"><i class="fa fa-id-card me-2"></i>Data Mahasiswa</a>
                <a href="{{ route('bimbingan.index') }}" class="nav-link"><i class="fa fa-chalkboard-teacher me-2"></i>Bimbingan</a>
                <a href="{{ route('seminar.index') }}" class="nav-link"><i class="fa fa-calendar me-2"></i>Seminar</a>
                <a href="{{ route('penguji.index') }}" class="nav-link"><i class="fa fa-user-check me-2"></i>Penguji</a>
                <a href="{{ route('datadosen.index') }}" class="nav-link"><i class="fa fa-users me-2"></i>Data Dosen</a>
                <a href="{{ route('proposal.index') }}" class="nav-link"><i class="fa fa-file-signature me-2"></i> Proposal</a>
                <a href="{{ route('suratpengantar.index') }}" class="nav-link"><i class="fa-solid fa-envelope me-2"></i>Surat Pengantar</a>
                <a href="{{ route('pemberkasan.index') }}" class="nav-link"><i class="fa-solid fa-folder me-2"></i>Pemberkasan</a>
              </nav>
          </div>
    <div class="col-10 d-flex flex-column">
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tambah Nilai Mahasiswa</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Koordinator PKL</small>
            </div>
        </div>

        <div class="container mt-4 flex-grow-1">
            <div class="card shadow-sm p-4">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="card mb-4">
                    <div class="card-body">
                        <form id="pdfImportForm" enctype="multipart/form-data">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="flex-grow-1 me-3">
                                    <label for="file_pdf" class="form-label mb-0">Pilih File Transkrip (PDF):</label>
                                    <input type="file" class="form-control mt-2" id="file_pdf" name="file_pdf" accept=".pdf" required>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" id="importPdfBtn" class="btn btn-danger">
                                        <i class="fa fa-upload"></i> Unggah & Proses PDF
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                {{-- ====================================================== --}}
                {{-- FORM UTAMA UNTUK MENYIMPAN DATA                      --}}
                {{-- ====================================================== --}}
                <form action="{{ route('nilai.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="sheet_name" id="sheet_name_hidden">
                    <input type="hidden" name="pdf_path" id="pdf_path_hidden">

                    <div class="row">
                        <h6 class="fw-semibold mt-2 mb-2 text-primary">🧑‍🎓 Data Mahasiswa</h6>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIM <span class="text-danger">*</span></label>
                            <input type="text" name="nim" class="form-control" value="{{ old('nim') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Angkatan</label>
                            <input type="text" name="angkatan" class="form-control" value="{{ old('angkatan') }}">
                        </div>

                        <h6 class="fw-semibold mt-4 mb-2 text-success">📘 Data Nilai</h6>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">IPK</label>
                            <input type="number" step="0.01" name="ipk" class="form-control" value="{{ old('ipk', 0) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total SKS</label>
                            <input type="number" name="total_sks" class="form-control" value="{{ old('total_sks', 0) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Total SKS Nilai D</label>
                            <input type="number" name="sks_d" class="form-control" value="{{ old('sks_d', 0) }}">
                        </div>

                        @foreach(['A','B+','B','C+','C','D','E'] as $grade)
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Jumlah {{ $grade }}</label>
                            <input type="number" name="count_{{ strtolower(str_replace('+','_plus',$grade)) }}" class="form-control" value="{{ old('count_'.strtolower(str_replace('+','_plus',$grade)), 0) }}">
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-3 d-flex justify-content-between">
                        <a href="{{ route('nilai.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</button>
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // === FUNGSI UNTUK MENGISI FORM SECARA OTOMATIS ===
        function populateForm(data) {
            if (!data || data.error) {
                alert('Gagal memuat data: ' + (data ? data.error : 'Respon tidak valid'));
                return;
            }
            document.querySelector('input[name="nim"]').value = data.nim ?? '';
            document.querySelector('input[name="nama"]').value = data.nama ?? '';
            document.querySelector('input[name="jurusan"]').value = data.jurusan ?? '';
            document.querySelector('input[name="angkatan"]').value = data.angkatan ?? '';
            document.querySelector('input[name="ipk"]').value = data.ipk ?? 0;
            document.querySelector('input[name="count_a"]').value = data.count_a ?? 0;
            document.querySelector('input[name="count_b_plus"]').value = data.count_b_plus ?? 0;
            document.querySelector('input[name="count_b"]').value = data.count_b ?? 0;
            document.querySelector('input[name="count_c_plus"]').value = data.count_c_plus ?? 0;
            document.querySelector('input[name="count_c"]').value = data.count_c ?? 0;
            document.querySelector('input[name="count_d"]').value = data.count_d ?? 0;
            document.querySelector('input[name="sks_d"]').value = data.sks_d ?? 0;
            document.querySelector('input[name="count_e"]').value = data.count_e ?? 0;
            document.querySelector('input[name="total_sks"]').value = data.total_sks ?? 0;
            document.getElementById('sheet_name_hidden').value = data.sheet_name ?? '';
            document.getElementById('pdf_path_hidden').value = data.pdf_path ?? '';
            alert('✅ Data berhasil diambil dan form terisi otomatis!');
        }

        // === LOGIKA UNTUK IMPORT PDF ===
        const pdfForm = document.getElementById('pdfImportForm');
        const importPdfBtn = document.getElementById('importPdfBtn');
        const pdfFileInput = document.getElementById('file_pdf');

        pdfForm.addEventListener('submit', async function(event) {
            event.preventDefault(); 
            if (!pdfFileInput.files.length) {
                return alert('Pilih file PDF terlebih dahulu!');
            }
            
            importPdfBtn.disabled = true; importPdfBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';
            
            const formData = new FormData();
            formData.append('file_pdf', pdfFileInput.files[0]);

            try {
                const response = await fetch(`{{ route('nilai.importPdf') }}`, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: formData
                });
                const data = await response.json();
                populateForm(data);
            } catch (err) {
                alert('Terjadi kesalahan: ' + err.message);
            } finally {
                importPdfBtn.disabled = false; importPdfBtn.innerHTML = '<i class="fa fa-upload"></i> Unggah & Proses PDF';
            }
        });
    });
    </script>
</body>
</html>