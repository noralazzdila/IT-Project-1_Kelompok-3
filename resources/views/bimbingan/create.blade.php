<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Bimbingan - Koordinator PKL</title>
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
            <a href="{{ route('bimbingan.index') }}" class="nav-link active"><i class="fa fa-chalkboard-teacher me-2"></i> Kelola Bimbingan</a>
            <a href="{{ route('seminar.index') }}" class="nav-link"><i class="fa fa-calendar me-2"></i> Kelola Seminar</a>
            <a href="{{ route('penguji.index') }}" class="nav-link"><i class="fa fa-user-check me-2"></i> Kelola Penguji</a>
            <a href="{{ route('datadosen.index') }}" class="nav-link"><i class="fa fa-users me-2"></i> Kelola Data Dosen</a>
            <a href="{{ route('proposal.index') }}" class="nav-link"><i class="fa fa-file-signature me-2"></i> Proposal</a>
            <a href="{{ route('suratpengantar.index') }}" class="nav-link"><i class="fa-solid fa-envelope me-2"></i> Kelola Surat Pengantar</a>
            <a href="{{ route('pemberkasan.index') }}" class="nav-link"><i class="fa-solid fa-folder me-2"></i> Kelola Pemberkasan</a>
        </nav>
    </div>

    <div class="col-10 d-flex flex-column">
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tambah Data Bimbingan</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Koordinator PKL</small>
            </div>
        </div>

        <div class="container mt-4 flex-grow-1">
            <div class="card shadow-sm p-4">
                <h5 class="fw-bold mb-3">Formulir Bimbingan Baru</h5>
                
                <form action="{{ route('bimbingan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="mahasiswa_nama" class="form-label">Nama Mahasiswa</label>
                        <input type="text" class="form-control @error('mahasiswa_nama') is-invalid @enderror" id="mahasiswa_nama" name="mahasiswa_nama" value="{{ old('mahasiswa_nama') }}" required>
                        @error('mahasiswa_nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                       <label for="nim" class="form-label">NIM</label>
                       <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}" required>
                        @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                         <label for="dosen_pembimbing" class="form-label">Dosen Pembimbing</label>
                         <select class="form-select @error('dosen_pembimbing') is-invalid @enderror" id="dosen_pembimbing" name="dosen_pembimbing" required>
                         <option value="">Pilih Dosen Pembimbing</option>
                         @php
                        // Ambil data dosen langsung di view (sementara)
                        $dosens = \App\Models\Dosen::orderBy('nama')->get();
                         @endphp
                        @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}" {{ old('dosen_pembimbing') == $dosen->id ? 'selected' : '' }}>
                            {{ $dosen->nama }} - {{ $dosen->nip }}
                        </option>
                        @endforeach
                        </select>
                         @error('dosen_pembimbing')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_bimbingan" class="form-label">Tanggal Bimbingan</label>
                        <input type="date" class="form-control @error('tanggal_bimbingan') is-invalid @enderror" id="tanggal_bimbingan" name="tanggal_bimbingan" value="{{ old('tanggal_bimbingan') }}" required>
                        @error('tanggal_bimbingan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="topik_bimbingan" class="form-label">Topik Bimbingan</label>
                        <input type="text" class="form-control @error('topik_bimbingan') is-invalid @enderror" id="topik_bimbingan" name="topik_bimbingan" value="{{ old('topik_bimbingan') }}" required>
                        @error('topik_bimbingan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="4" required>{{ old('catatan') }}</textarea>
                        @error('catatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="Menunggu" {{ old('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Disetujui" {{ old('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Revisi" {{ old('status') == 'Revisi' ? 'selected' : '' }}>Revisi</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('bimbingan.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
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
</body>
</html>