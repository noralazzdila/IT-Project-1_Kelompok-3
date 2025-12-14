@extends('dosen.layouts.app')

@section('title', 'Tambah Nilai - Dosen')

@section('header-title', 'Tambah Nilai Mahasiswa')

@section('content')
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
<form action="{{ route('dosen.nilai.storedosen') }}" method="POST">
    @csrf
    <input type="hidden" name="sheet_name" id="sheet_name_hidden">
    <input type="hidden" name="pdf_path" id="pdf_path_hidden">

    <div class="row">
        <h6 class="fw-semibold mt-2 mb-2 text-primary">Data Mahasiswa</h6>
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
        <a href="{{ route('dosen.nilai.indexdosen') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Batal</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</button>
    </div>
</form>

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
            const response = await fetch(`{{ route('dosen.importpdf') }}`, {
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
@endsection