@extends('staf.layouts.app')

@section('title', 'Tambah Nilai - Staf')

@section('header-title', 'Tambah Nilai Mahasiswa')

@section('content')
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

        {{-- ====================================================== --}}
        {{-- BAGIAN IMPORT DENGAN SISTEM TAB BARU --}}
        {{-- ====================================================== --}}
        <div class="card mb-4">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="importTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="sheet-tab" data-bs-toggle="tab" data-bs-target="#sheet-tab-pane" type="button" role="tab" aria-controls="sheet-tab-pane" aria-selected="true">
                            <i class="fa fa-table"></i> Import dari Google Sheet
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pdf-tab" data-bs-toggle="tab" data-bs-target="#pdf-tab-pane" type="button" role="tab" aria-controls="pdf-tab-pane" aria-selected="false">
                            <i class="fa fa-file-pdf"></i> Import dari PDF
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="importTabContent">
                    {{-- TAB 1: GOOGLE SHEET --}}
                    <div class="tab-pane fade show active" id="sheet-tab-pane" role="tabpanel" aria-labelledby="sheet-tab" tabindex="0">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="flex-grow-1 me-3">
                                <label for="sheet_name_select" class="form-label mb-0">Pilih Sheet Mahasiswa:</label>
                                <select id="sheet_name_select" class="form-select mt-2">
                                    <option value="">-- Memuat daftar sheet... --</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 2: PDF --}}
                    <div class="tab-pane fade" id="pdf-tab-pane" role="tabpanel" aria-labelledby="pdf-tab" tabindex="0">
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
            </div>
        </div>

        {{-- ====================================================== --}}
        {{-- FORM UTAMA UNTUK MENYIMPAN DATA --}}
        {{-- ====================================================== --}}
        <form action="{{ route('staf.nilai.store') }}" method="POST">
            @csrf
            <input type="hidden" name="sheet_name" id="sheet_name_hidden">
            <input type="hidden" name="pdf_path" id="pdf_path_hidden">

            <div class="row">
                <h6 class="fw-semibold mt-2 mb-2 text-primary">🧑‍🎓 Data Mahasiswa</h6>
                <div class="col-md-6 mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}" required>
                    @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
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

        importPdfBtn.disabled = true;
        importPdfBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';

        const formData = new FormData();
        formData.append('file_pdf', pdfFileInput.files[0]);

        try {
            // ✅ PERBAIKAN ADA DI SINI
            const response = await fetch(`{{ route('nilai.importPdf') }}`, {
                method: 'POST', 
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });
            const data = await response.json();
            populateForm(data);
        } catch (err) {
            alert('Terjadi kesalahan: ' + err.message);
        } finally {
            importPdfBtn.disabled = false;
            importPdfBtn.innerHTML = '<i class="fa fa-upload"></i> Unggah & Proses PDF';
        }
    });
});
</script>
@endsection
