<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Seminar - Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f7fa; }
        .container { max-width: 900px; margin-top: 32px; }
        .card-header { background: #113F67; color: #fff; }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Detail Jadwal Seminar</h3>
            <div>
                <a href="{{ route('seminar.jadwal') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">
                <strong>{{ $seminar->nama_mahasiswa }} — {{ $seminar->nim }}</strong>
            </div>
            <div class="card-body">
                <p><strong>Judul:</strong> {{ $seminar->judul }}</p>
                <p><strong>Pembimbing:</strong> {{ $seminar->nama_pembimbing }}</p>
                <p><strong>Penguji:</strong> {{ $seminar->nama_penguji }}</p>
                <p><strong>Jadwal:</strong> {{ \Carbon\Carbon::parse($seminar->tanggal)->isoFormat('dddd, D MMM Y') }} — {{ date('H:i', strtotime($seminar->jam_mulai)) }} s/d {{ date('H:i', strtotime($seminar->jam_selesai)) }}</p>
                <p><strong>Ruang:</strong> {{ $seminar->ruang }}</p>
                @if($seminar->keterangan ?? false)
                    <p><strong>Keterangan:</strong> {{ $seminar->keterangan }}</p>
                @endif
            </div>
        </div>

        <footer class="text-center text-muted mt-4">
            <small>&copy; 2025 SIPRAKELRA - Sistem Informasi PKL</small>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
