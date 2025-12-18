<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penilaian Tempat PKL - Metode SAW</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --dark-text: #2d3748;
            --success-color: #48bb78;
            --warning-color: #ed8936;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        
        .main-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .nav-tabs {
            border: none;
            margin-bottom: 30px;
        }
        
        .nav-tabs .nav-link {
            border: none;
            background: white;
            margin-right: 10px;
            border-radius: 10px;
            padding: 12px 25px;
            color: var(--dark-text);
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .nav-tabs .nav-link:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
        }
        
        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .penilaian-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .form-penilaian label {
            color: var(--dark-text);
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-penilaian .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-penilaian .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
      
        
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        .criteria-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .criteria-box:hover {
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
        }
        
        .criteria-box input[type="number"] {
            max-width: 150px;
            font-size: 1.1rem;
            font-weight: 600;
            text-align: center;
        }
        
        .criteria-icon {
            font-size: 2rem;
            margin-right: 15px;
            color: #667eea;
        }
        
        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 15px 40px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }
        
        .alert-info-custom {
            background: #e8f4f8;
            border-left: 4px solid #17a2b8;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .ranking-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
        }
        
        .ranking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .rank-badge {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
        }
        
        .rank-1 { background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%); }
        .rank-2 { background: linear-gradient(135deg, #C0C0C0 0%, #808080 100%); }
        .rank-3 { background: linear-gradient(135deg, #CD7F32 0%, #8B4513 100%); }
        .rank-other { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        
        .score-progress {
            height: 25px;
            border-radius: 10px;
            background: #e9ecef;
            overflow: hidden;
        }
        
        .score-bar {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            transition: width 1s ease;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="main-header">
        <div class="container">
            <div class="text-center">
                <h2 class="mb-2">
                    <i class="bi bi-calculator me-2"></i>
                    Sistem Penilaian Tempat PKL
                </h2>
                <p class="mb-0" style="opacity: 0.9;">
                    Menggunakan Metode SAW (Simple Additive Weighting)
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#penilaian">
                    <i class="bi bi-pencil-square me-2"></i>Form Penilaian
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#ranking">
                    <i class="bi bi-trophy me-2"></i>Ranking Tempat PKL
                </a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- TAB 1: FORM PENILAIAN -->
            <div class="tab-pane fade show active" id="penilaian">
                <div class="penilaian-card">
                    <div class="text-center mb-4">
                        <h4 class="mb-2">
                            <i class="bi bi-star-fill me-2"></i>
                            Nilai Tempat PKL Favoritmu
                        </h4>
                        <p class="text-muted mb-0">
                            Bantu mahasiswa lain dengan membagikan pengalamanmu di tempat PKL!
                        </p>
                    </div>
                    
                    <div id="alertContainer"></div>
                    
                    <div class="alert-info-custom">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <strong>Catatan:</strong> Penilaian Anda akan digunakan dalam perhitungan metode SAW untuk merangking tempat PKL terbaik.
                    </div>
                    
                    <form id="formPenilaian">
                        <!-- PILIH TEMPAT PKL -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="tempat_pkl_id">
                                    <i class="bi bi-building me-2"></i>Pilih Tempat PKL *
                                </label>
                                <select name="tempat_pkl_id" id="tempat_pkl_id" class="form-control" required>
                                    <option value="">-- Pilih Tempat PKL --</option>
                                    <option value="1">PT Telkom Indonesia - Banjarmasin</option>
                                    <option value="2">Bank Mandiri Cabang Banjarmasin</option>
                                    <option value="3">Dinas Komunikasi dan Informatika Kalsel</option>
                                    <option value="4">PT PLN (Persero) Wilayah Kalimantan</option>
                                    <option value="5">Rumah Sakit Umum Ulin Banjarmasin</option>
                                    <option value="6">PT Pertamina RU VI Balongan</option>
                                    <option value="7">Kementerian Keuangan Regional Kalimantan</option>
                                    <option value="8">PT Bank Rakyat Indonesia Cabang Banjarmasin</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- NAMA TEMPAT & JARAK -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="nama_tempat">
                                    <i class="bi bi-pin-map me-2"></i>Nama Lengkap Tempat PKL *
                                </label>
                                <input type="text" name="nama_tempat" id="nama_tempat" 
                                       class="form-control" 
                                       placeholder="Contoh: PT Telkom Indonesia - Cabang Banjarmasin"
                                       required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="jarak">
                                    <i class="bi bi-speedometer2 me-2"></i>Jarak dari Kampus (KM) *
                                </label>
                                <input type="number" step="0.1" name="jarak" id="jarak" 
                                       class="form-control" 
                                       placeholder="Contoh: 5.5"
                                       required>
                                <small class="text-muted">Perkiraan jarak dalam kilometer</small>
                            </div>
                        </div>
                        
                        <!-- ALAMAT -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="alamat">
                                    <i class="bi bi-geo-alt me-2"></i>Alamat Lengkap Tempat PKL *
                                </label>
                                <textarea name="alamat" id="alamat" rows="2" 
                                          class="form-control" 
                                          placeholder="Contoh: Jl. A. Yani Km. 6 No. 123, Kebun Bunga, Banjarmasin Timur"
                                          required></textarea>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        <h5 class="mb-4 text-center" style="color: var(--primary-color);">
                            <i class="bi bi-clipboard-check me-2"></i>Penilaian Kriteria (1-5)
                        </h5>
                        
                        <!-- KRITERIA 1: FASILITAS -->
                        <div class="criteria-box">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-gear-wide-connected criteria-icon"></i>
                                <div class="w-100">
                                    <label class="mb-1">1. Fasilitas Tempat PKL (C1) *</label>
                                    <small class="d-block text-muted mb-2">
                                        Kelengkapan fasilitas (ruang kerja, komputer, internet, dll)
                                    </small>
                                    <input type="number" name="fasilitas" id="fasilitas" class="form-control" min="1" max="5" placeholder="Masukkan nilai 1-5" required>
                                    <small class="text-muted">1 = Sangat Kurang | 5 = Sangat Baik</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- KRITERIA 2: PROGRAM MAGANG -->
                        <div class="criteria-box">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-journal-code criteria-icon"></i>
                                <div class="w-100">
                                    <label class="mb-1">2. Program Magang/Pembelajaran (C2) *</label>
                                    <small class="d-block text-muted mb-2">
                                        Kualitas bimbingan, tugas yang diberikan, dan kesempatan belajar
                                    </small>
                                    <input type="number" name="program_magang" id="program_magang" class="form-control" min="1" max="5" placeholder="Masukkan nilai 1-5" required>
                                    <small class="text-muted">1 = Sangat Kurang | 5 = Sangat Baik</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- KRITERIA 3: REPUTASI PERUSAHAAN -->
                        <div class="criteria-box">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-award criteria-icon"></i>
                                <div class="w-100">
                                    <label class="mb-1">3. Reputasi Perusahaan (C3) *</label>
                                    <small class="d-block text-muted mb-2">
                                        Kredibilitas, nama besar, dan prestise perusahaan
                                    </small>
                                    <input type="number" name="reputasi" id="reputasi" class="form-control" min="1" max="5" placeholder="Masukkan nilai 1-5" required>
                                    <small class="text-muted">1 = Sangat Kurang Dikenal | 5 = Sangat Terkenal</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- KRITERIA 4: KONDISI LINGKUNGAN -->
                        <div class="criteria-box">
                            <div class="d-flex align-items-center mb-3">
                                <i class="bi bi-tree criteria-icon"></i>
                                <div class="w-100">
                                    <label class="mb-1">4. Kondisi Lingkungan Kerja (C4) *</label>
                                    <small class="d-block text-muted mb-2">
                                        Kenyamanan, kebersihan, suasana kerja, dan keamanan lingkungan
                                    </small>
                                    <input type="number" name="kondisi_lingkungan" id="kondisi_lingkungan" class="form-control" min="1" max="5" placeholder="Masukkan nilai 1-5" required>
                                    <small class="text-muted">1 = Sangat Tidak Nyaman | 5 = Sangat Nyaman</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CATATAN TAMBAHAN -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label for="catatan">
                                    <i class="bi bi-chat-left-text me-2"></i>Catatan Tambahan (Opsional)
                                </label>
                                <textarea name="catatan" id="catatan" rows="3" 
                                          class="form-control" 
                                          placeholder="Ceritakan pengalaman atau saran Anda tentang tempat PKL ini..."></textarea>
                            </div>
                        </div>
                        
                        <!-- SUBMIT BUTTON -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary submit-btn">
                                <i class="bi bi-send-fill me-2"></i>
                                Kirim Penilaian & Hitung SAW
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TAB 2: RANKING TEMPAT PKL -->
            <div class="tab-pane fade" id="ranking">
                <div class="penilaian-card">
                    <h4 class="mb-4 text-center">
                        <i class="bi bi-trophy-fill me-2"></i>
                        Top 5 Tempat PKL Terbaik
                    </h4>
                    <div id="rankingContainer">
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-3">Belum ada data ranking. Silakan isi penilaian terlebih dahulu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Data Tempat PKL
        const tempatPklData = {
            1: { nama: 'PT Telkom Indonesia - Banjarmasin', alamat: 'Jl. Lambung Mangkurat No. 16' },
            2: { nama: 'Bank Mandiri Cabang Banjarmasin', alamat: 'Jl. Sudirman No. 88' },
            3: { nama: 'Dinas Komunikasi dan Informatika Kalsel', alamat: 'Jl. RE Martadinata No. 1' },
            4: { nama: 'PT PLN (Persero) Wilayah Kalimantan', alamat: 'Jl. A. Yani Km. 5' },
            5: { nama: 'Rumah Sakit Umum Ulin Banjarmasin', alamat: 'Jl. A. Yani Km. 2' },
            6: { nama: 'PT Pertamina RU VI Balongan', alamat: 'Jl. Merdeka No. 45' },
            7: { nama: 'Kementerian Keuangan Regional Kalimantan', alamat: 'Jl. Pangeran Samudera No. 12' },
            8: { nama: 'PT Bank Rakyat Indonesia Cabang Banjarmasin', alamat: 'Jl. Lambung Mangkurat No. 25' }
        };

        // Bobot default (dapat diubah di tab Pengaturan Bobot)
        let weights = {
            jarak: 0.44284704,
            fasilitas: 0.23916185,
            program_magang: 0.16029806,
            reputasi: 0.09758812,
            kondisi_lingkungan: 0.06010494
        };

        // Auto-fill nama saat memilih tempat PKL
        document.getElementById('tempat_pkl_id').addEventListener('change', function() {
            const id = this.value;
            if (id && tempatPklData[id]) {
                document.getElementById('nama_tempat').value = tempatPklData[id].nama;
            }
        });

        // Form Submit Handler
        document.getElementById('formPenilaian').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validasi rating
            const ratings = ['fasilitas', 'program_magang', 'reputasi', 'kondisi_lingkungan'];
            let isValid = true;
            
            for (let name of ratings) {
                const input = document.getElementById(name);
                const value = parseInt(input.value);
                
                if (!input.value || value < 1 || value > 5) {
                    isValid = false;
                    showAlert('danger', `Mohon masukkan nilai 1-5 untuk kriteria ${name.replace(/_/g, ' ')}`);
                    input.focus();
                    return;
                }
            }
            
            // Ambil data form
            const formData = {
                tempat_pkl_id: document.getElementById('tempat_pkl_id').value,
                nama_tempat: document.getElementById('nama_tempat').value,
                jarak: parseFloat(document.getElementById('jarak').value),
                alamat: document.getElementById('alamat').value,
                fasilitas: parseInt(document.getElementById('fasilitas').value),
                program_magang: parseInt(document.getElementById('program_magang').value),
                reputasi: parseInt(document.getElementById('reputasi').value),
                kondisi_lingkungan: parseInt(document.getElementById('kondisi_lingkungan').value),
                catatan: document.getElementById('catatan').value,
                tanggal: new Date().toLocaleString('id-ID')
            };
            
            // Simpan penilaian
            let penilaianList = JSON.parse(localStorage.getItem('penilaianPKL') || '[]');
            penilaianList.push(formData);
            localStorage.setItem('penilaianPKL', JSON.stringify(penilaianList));
            
            // Hitung SAW
            calculateSAW();
            
            // Tampilkan pesan sukses
            showAlert('success', 'Terima kasih! Penilaian berhasil disimpan dan perhitungan SAW telah diperbarui.');
            
            // Reset form
            this.reset();
            
            // Pindah ke tab ranking
            setTimeout(() => {
                const rankingTab = new bootstrap.Tab(document.querySelector('[href="#ranking"]'));
                rankingTab.show();
            }, 1500);
        });

        // Fungsi untuk menghitung SAW
        function calculateSAW() {
            const penilaianList = JSON.parse(localStorage.getItem('penilaianPKL') || '[]');
            
            if (penilaianList.length === 0) return;
            
            // 1. Hitung rata-rata per tempat PKL
            const avgByTempat = {};
            penilaianList.forEach(p => {
                if (!avgByTempat[p.tempat_pkl_id]) {
                    avgByTempat[p.tempat_pkl_id] = {
                        nama: p.nama_tempat,
                        alamat: p.alamat,
                        fasilitas: [],
                        program_magang: [],
                        reputasi: [],
                        kondisi_lingkungan: [],
                        jarak: []
                    };
                }
                avgByTempat[p.tempat_pkl_id].fasilitas.push(p.fasilitas);
                avgByTempat[p.tempat_pkl_id].program_magang.push(p.program_magang);
                avgByTempat[p.tempat_pkl_id].reputasi.push(p.reputasi);
                avgByTempat[p.tempat_pkl_id].kondisi_lingkungan.push(p.kondisi_lingkungan);
                avgByTempat[p.tempat_pkl_id].jarak.push(p.jarak);
            });
            
            // Hitung rata-rata
            const alternatives = [];
            for (let id in avgByTempat) {
                const data = avgByTempat[id];
                alternatives.push({
                    id: id,
                    nama: data.nama,
                    alamat: data.alamat,
                    fasilitas: avg(data.fasilitas),
                    program_magang: avg(data.program_magang),
                    reputasi: avg(data.reputasi),
                    kondisi_lingkungan: avg(data.kondisi_lingkungan),
                    jarak: avg(data.jarak),
                    jumlah_penilai: data.fasilitas.length
                });
            }
            
            // 2. Normalisasi (semua kriteria benefit kecuali jarak yang cost)
            const maxValues = {
                fasilitas: Math.max(...alternatives.map(a => a.fasilitas)),
                program_magang: Math.max(...alternatives.map(a => a.program_magang)),
                reputasi: Math.max(...alternatives.map(a => a.reputasi)),
                kondisi_lingkungan: Math.max(...alternatives.map(a => a.kondisi_lingkungan))
            };
            
            const minJarak = Math.min(...alternatives.map(a => a.jarak));
            
            alternatives.forEach(alt => {
                alt.normalized = {
                    fasilitas: alt.fasilitas / maxValues.fasilitas,
                    program_magang: alt.program_magang / maxValues.program_magang,
                    reputasi: alt.reputasi / maxValues.reputasi,
                    kondisi_lingkungan: alt.kondisi_lingkungan / maxValues.kondisi_lingkungan
                };
            });
            
            // 3. Hitung nilai preferensi (Vi)
            alternatives.forEach(alt => {
                alt.finalScore = (
                    alt.normalized.fasilitas * weights.fasilitas +
                    alt.normalized.program_magang * weights.program_magang +
                    alt.normalized.reputasi * weights.reputasi +
                    alt.normalized.kondisi_lingkungan * weights.kondisi_lingkungan
                );
            });
            
            // 4. Ranking
            alternatives.sort((a, b) => b.finalScore - a.finalScore);
            alternatives.forEach((alt, index) => {
                alt.rank = index + 1;
            });
            
            // Simpan hasil SAW
            localStorage.setItem('sawResults', JSON.stringify(alternatives));
            
            // Update tampilan
            displayRanking(alternatives);
        }

        // Fungsi helper untuk menghitung rata-rata
        function avg(arr) {
            return arr.reduce((a, b) => a + b, 0) / arr.length;
        }

        // Tampilkan ranking
        function displayRanking(alternatives) {
            const container = document.getElementById('rankingContainer');
            
            if (alternatives.length === 0) {
                container.innerHTML = `
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                        <p class="mt-3">Belum ada data ranking. Silakan isi penilaian terlebih dahulu.</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            alternatives.slice(0, 5).forEach(alt => {
                const rankClass = alt.rank === 1 ? 'rank-1' : alt.rank === 2 ? 'rank-2' : alt.rank === 3 ? 'rank-3' : 'rank-other';
                const scorePercent = (alt.finalScore * 100).toFixed(2);
                
                html += `
                    <div class="ranking-card">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="rank-badge ${rankClass}">
                                    ${alt.rank}
                                </div>
                            </div>
                            <div class="col">
                                <h5 class="mb-1">${alt.nama}</h5>
                                <p class="text-muted mb-2">
                                    <i class="bi bi-geo-alt me-1"></i>${alt.alamat}
                                </p>
                                <div class="score-progress">
                                    <div class="score-bar" style="width: ${scorePercent}%">
                                        ${alt.finalScore.toFixed(4)} (${scorePercent}%)
                                    </div>
                                </div>
                                <small class="text-muted mt-1 d-block">
                                    <i class="bi bi-people me-1"></i>${alt.jumlah_penilai} orang penilai
                                </small>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        // Fungsi untuk menampilkan alert
        function showAlert(type, message) {
            const alertContainer = document.getElementById('alertContainer');
            const iconClass = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';
            
            alertContainer.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    <i class="bi ${iconClass} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
            setTimeout(() => {
                const alert = alertContainer.querySelector('.alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alertContainer.innerHTML = '', 150);
                }
            }, 5000);
        }

        // Load data saat halaman dimuat
        window.addEventListener('load', function() {
            calculateSAW();
        });
    </script>
</body>
</html>