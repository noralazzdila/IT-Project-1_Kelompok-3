<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Seminar - Koordinator PKL</title>
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
            <a href="{{ route('nilai.index') }}" class="nav-link "><i class="fa fa-graduation-cap me-2"></i>Nilai</a>
            <a href="{{ route('tempatpkl.index') }}" class="nav-link"><i class="fa fa-building me-2"></i>Tempat PKL</a>
            <a href="{{ route('datamahasiswa.index') }}" class="nav-link"><i class="fa fa-id-card me-2"></i>Data Mahasiswa</a>
            <a href="{{ route('bimbingan.index') }}" class="nav-link"><i class="fa fa-chalkboard-teacher me-2"></i>Bimbingan</a>
            <a href="{{ route('seminar.index') }}" class="nav-link active"><i class="fa fa-calendar me-2"></i>Seminar</a>
            <a href="{{ route('penguji.index') }}" class="nav-link"><i class="fa fa-user-check me-2"></i>Penguji</a>
            <a href="{{ route('datadosen.index') }}" class="nav-link"><i class="fa fa-users me-2"></i>Data Dosen</a>
            <a href="{{ route('proposal.index') }}" class="nav-link"><i class="fa fa-file-signature me-2"></i> Proposal</a>
            <a href="{{ route('suratpengantar.index') }}" class="nav-link"><i class="fa-solid fa-envelope me-2"></i>Surat Pengantar</a>
            <a href="{{ route('pemberkasan.index') }}" class="nav-link"><i class="fa-solid fa-folder me-2"></i>Pemberkasan</a>
        </nav>
    </div>

    <div class="col-10 d-flex flex-column">
        <div class="header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tambah Jadwal Seminar</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Koordinator PKL</small>
            </div>
        </div>

        <div class="container mt-4 flex-grow-1">
            <div class="card shadow-sm p-4">
                <h5 class="fw-bold mb-3">Formulir Jadwal Seminar Baru</h5>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('seminar.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                            <input type="text" class="form-control" name="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" placeholder="Ketik nama lengkap mahasiswa">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}" required>
                            @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Seminar</label>
                        <textarea class="form-control" name="judul" rows="3" placeholder="Ketik judul laporan PKL">{{ old('judul') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
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
                        <div class="col-md-6 mb-3">
                            <label for="nama_penguji" class="form-label">Nama Penguji</label>
                            <input type="text" class="form-control" name="nama_penguji" value="{{ old('nama_penguji') }}" placeholder="Ketik nama dosen penguji">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Seminar</label>
                        <input type="date" class="form-control" name="tanggal" value="{{ old('tanggal') }}">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" name="jam_mulai" value="{{ old('jam_mulai') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" name="jam_selesai" value="{{ old('jam_selesai') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="ruang" class="form-label">Ruang</label>
                            <input type="text" class="form-control" name="ruang" value="{{ old('ruang') }}" placeholder="Contoh: Lab 1">
                        </div>
                    </div>
                    
                    <div class="mt-3 d-flex justify-content-end">
                        <a href="{{ route('seminar.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Jadwal</button>
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