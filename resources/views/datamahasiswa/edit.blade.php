<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa - Koordinator PKL</title>
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
            <a href="{{ route('datamahasiswa.index') }}" class="nav-link active"><i class="fa fa-id-card me-2"></i>Data Mahasiswa</a>
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
            <h5 class="mb-0">Edit Data Mahasiswa</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Koordinator PKL</small>
            </div>
        </div>

        <div class="container mt-4 flex-grow-1">
            <div class="card shadow-sm p-4">
                <h5 class="fw-bold mb-3">Formulir Edit Data Mahasiswa</h5>
                
                <form action="{{ route('datamahasiswa.update', $datamahasiswa->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                     <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $datamahasiswa->nama) }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $datamahasiswa->nim) }}" required>
                            @error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki" value="Laki-laki" {{ old('jenis_kelamin', $datamahasiswa->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="laki-laki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" {{ old('jenis_kelamin', $datamahasiswa->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                            </div>
                            @error('jenis_kelamin')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                             <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $datamahasiswa->tanggal_lahir ? $datamahasiswa->tanggal_lahir->format('Y-m-d') : '') }}" required>
                            @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                             <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $datamahasiswa->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                     <hr>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="prodi" class="form-label">Program Studi</label>
                            <input type="text" class="form-control @error('prodi') is-invalid @enderror" id="prodi" name="prodi" value="{{ old('prodi', $datamahasiswa->prodi) }}" required>
                            @error('prodi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" value="{{ old('kelas', $datamahasiswa->kelas) }}" required>
                            @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tahun_angkatan" class="form-label">Tahun Angkatan</label>
                            <input type="number" class="form-control @error('tahun_angkatan') is-invalid @enderror" id="tahun_angkatan" name="tahun_angkatan" value="{{ old('tahun_angkatan', $datamahasiswa->tahun_angkatan) }}" placeholder="YYYY" required>
                            @error('tahun_angkatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                     <div class="mb-3">
                        <label for="dosen_pembimbing" class="form-label">Dosen Pembimbing</label>
                        <input type="text" class="form-control @error('dosen_pembimbing') is-invalid @enderror" id="dosen_pembimbing" name="dosen_pembimbing" value="{{ old('dosen_pembimbing', $datamahasiswa->dosen_pembimbing) }}" required>
                        @error('dosen_pembimbing')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                     <div class="mb-3">
                        <label for="tempat_pkl" class="form-label">Tempat PKL</label>
                        <input type="text" class="form-control @error('tempat_pkl') is-invalid @enderror" id="tempat_pkl" name="tempat_pkl" value="{{ old('tempat_pkl', $datamahasiswa->tempat_pkl) }}" required>
                        @error('tempat_pkl')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status_pkl" class="form-label">Status PKL</label>
                            <select class="form-select @error('status_pkl') is-invalid @enderror" id="status_pkl" name="status_pkl" required>
                                <option value="Belum Mulai" {{ old('status_pkl', $datamahasiswa->status_pkl) == 'Belum Mulai' ? 'selected' : '' }}>Belum Mulai</option>
                                <option value="Sedang PKL" {{ old('status_pkl', $datamahasiswa->status_pkl) == 'Sedang PKL' ? 'selected' : '' }}>Sedang PKL</option>
                                <option value="Selesai" {{ old('status_pkl', $datamahasiswa->status_pkl) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status_pkl')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_hp" class="form-label">No. HP</label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $datamahasiswa->no_hp) }}" required>
                            @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('datamahasiswa.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
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