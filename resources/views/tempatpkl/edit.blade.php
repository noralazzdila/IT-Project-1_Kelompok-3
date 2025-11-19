<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tempat PKL - Koordinator PKL</title>
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
            <a href="{{ route('tempatpkl.index') }}" class="nav-link active"><i class="fa fa-building me-2"></i>Tempat PKL</a>
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
            <h5 class="mb-0">Edit Data Tempat PKL</h5>
            <div class="text-end">
                <span class="fw-semibold">Dwi Agung Wibowo, M.Kom</span> <br>
                <small>Koordinator PKL</small>
            </div>
        </div>

        <div class="container mt-4 flex-grow-1">
            <div class="card shadow-sm p-4">
                <h5 class="fw-bold mb-3">Formulir Edit Data Tempat PKL</h5>
                
                <form action="{{ route('tempatpkl.update', $tempatpkl->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror" id="nama_perusahaan" name="nama_perusahaan" value="{{ old('nama_perusahaan', $tempatpkl->nama_perusahaan) }}">
                            @error('nama_perusahaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jarak_lokasi" class="form-label">Jarak Lokasi (km)</label>
                            <input type="number" step="0.01" class="form-control @error('jarak_lokasi') is-invalid @enderror" id="jarak_lokasi" name="jarak_lokasi" value="{{ old('jarak_lokasi', $tempatpkl->jarak_lokasi) }}">
                            @error('jarak_lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat_perusahaan" class="form-label">Alamat Perusahaan</label>
                        <textarea class="form-control @error('alamat_perusahaan') is-invalid @enderror" id="alamat_perusahaan" name="alamat_perusahaan" rows="3">{{ old('alamat_perusahaan', $tempatpkl->alamat_perusahaan) }}</textarea>
                        @error('alamat_perusahaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="reputasi_perusahaan" class="form-label">Reputasi Perusahaan</label>
                            <select class="form-select @error('reputasi_perusahaan') is-invalid @enderror" id="reputasi_perusahaan" name="reputasi_perusahaan">
                                <option value="">Pilih Reputasi</option>
                                <option value="Sangat Baik" {{ old('reputasi_perusahaan', $tempatpkl->reputasi_perusahaan) == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik</option>
                                <option value="Baik" {{ old('reputasi_perusahaan', $tempatpkl->reputasi_perusahaan) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Cukup" {{ old('reputasi_perusahaan', $tempatpkl->reputasi_perusahaan) == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                <option value="Buruk" {{ old('reputasi_perusahaan', $tempatpkl->reputasi_perusahaan) == 'Buruk' ? 'selected' : '' }}>Buruk</option>
                                <option value="Sangat Buruk" {{ old('reputasi_perusahaan', $tempatpkl->reputasi_perusahaan) == 'Sangat Buruk' ? 'selected' : '' }}>Sangat Buruk</option>
                            </select>
                            @error('reputasi_perusahaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fasilitas" class="form-label">Fasilitas</label>
                            <select class="form-select @error('fasilitas') is-invalid @enderror" id="fasilitas" name="fasilitas">
                                <option value="">Pilih Ketersediaan Fasilitas</option>
                                <option value="Sangat Memadai" {{ old('fasilitas', $tempatpkl->fasilitas) == 'Sangat Memadai' ? 'selected' : '' }}>Sangat Memadai</option>
                                <option value="Memadai" {{ old('fasilitas', $tempatpkl->fasilitas) == 'Memadai' ? 'selected' : '' }}>Memadai</option>
                                <option value="Cukup Memadai" {{ old('fasilitas', $tempatpkl->fasilitas) == 'Cukup Memadai' ? 'selected' : '' }}>Cukup Memadai</option>
                                <option value="Tidak Memadai" {{ old('fasilitas', $tempatpkl->fasilitas) == 'Tidak Memadai' ? 'selected' : '' }}>Tidak Memadai</option>
                                <option value="Sangat Tidak Memadai" {{ old('fasilitas', $tempatpkl->fasilitas) == 'Sangat Tidak Memadai' ? 'selected' : '' }}>Sangat Tidak Memadai</option>
                            </select>
                            @error('fasilitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                     <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kesesuaian_program" class="form-label">Kesesuaian Program</label>
                            <select class="form-select @error('kesesuaian_program') is-invalid @enderror" id="kesesuaian_program" name="kesesuaian_program">
                                <option value="">Pilih Kesesuaian Program</option>
                                <option value="Sangat Sesuai" {{ old('kesesuaian_program', $tempatpkl->kesesuaian_program) == 'Sangat Sesuai' ? 'selected' : '' }}>Sangat Sesuai</option>
                                <option value="Sesuai" {{ old('kesesuaian_program', $tempatpkl->kesesuaian_program) == 'Sesuai' ? 'selected' : '' }}>Sesuai</option>
                                <option value="Cukup Sesuai" {{ old('kesesuaian_program', $tempatpkl->kesesuaian_program) == 'Cukup Sesuai' ? 'selected' : '' }}>Cukup Sesuai</option>
                                <option value="Tidak Sesuai" {{ old('kesesuaian_program', $tempatpkl->kesesuaian_program) == 'Tidak Sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
                                <option value="Sangat Tidak Sesuai" {{ old('kesesuaian_program', $tempatpkl->kesesuaian_program) == 'Sangat Tidak Sesuai' ? 'selected' : '' }}>Sangat Tidak Sesuai</option>
                            </select>
                            @error('kesesuaian_program')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                         <div class="col-md-6 mb-3">
                            <label for="lingkungan_kerja" class="form-label">Lingkungan Kerja</label>
                            <select class="form-select @error('lingkungan_kerja') is-invalid @enderror" id="lingkungan_kerja" name="lingkungan_kerja">
                                <option value="">Pilih Kondisi Lingkungan Kerja</option>
                                <option value="Sangat Kondusif" {{ old('lingkungan_kerja', $tempatpkl->lingkungan_kerja) == 'Sangat Kondusif' ? 'selected' : '' }}>Sangat Kondusif</option>
                                <option value="Kondusif" {{ old('lingkungan_kerja', $tempatpkl->lingkungan_kerja) == 'Kondusif' ? 'selected' : '' }}>Kondusif</option>
                                <option value="Cukup Kondusif" {{ old('lingkungan_kerja', $tempatpkl->lingkungan_kerja) == 'Cukup Kondusif' ? 'selected' : '' }}>Cukup Kondusif</option>
                                <option value="Tidak Kondusif" {{ old('lingkungan_kerja', $tempatpkl->lingkungan_kerja) == 'Tidak Kondusif' ? 'selected' : '' }}>Tidak Kondusif</option>
                                <option value="Sangat Tidak Kondusif" {{ old('lingkungan_kerja', $tempatpkl->lingkungan_kerja) == 'Sangat Tidak Kondusif' ? 'selected' : '' }}>Sangat Tidak Kondusif</option>
                            </select>
                            @error('lingkungan_kerja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-end">
                        <a href="{{ route('tempatpkl.index') }}" class="btn btn-secondary me-2"><i class="fa fa-times"></i> Batal</a>
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