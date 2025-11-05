<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail IPK Mahasiswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
      <div class="card-header bg-primary text-white text-center rounded-top-4">
        <h4 class="mb-0"><i class="fa-solid fa-user-graduate me-2"></i> Detail IPK & Status Akademik</h4>
      </div>
      <div class="card-body p-4">
        <div class="row mb-4">
          <div class="col-md-6">
            <h6><i class="fa-solid fa-id-card me-2 text-primary"></i>Nama Mahasiswa</h6>
            <p class="fw-semibold">Rizky Pratama</p>
          </div>
          <div class="col-md-6">
            <h6><i class="fa-solid fa-hashtag me-2 text-primary"></i>NIM</h6>
            <p class="fw-semibold">2301020001</p>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-6">
            <h6><i class="fa-solid fa-layer-group me-2 text-primary"></i>Semester</h6>
            <p class="fw-semibold">3 (Tiga)</p>
          </div>
          <div class="col-md-6">
            <h6><i class="fa-solid fa-graduation-cap me-2 text-primary"></i>IPK Terakhir</h6>
            <p class="fw-semibold">0,00</p>
          </div>
        </div>

        <hr>

        <h5 class="mb-3 text-primary"><i class="fa-solid fa-book-open-reader me-2"></i>Daftar Nilai Semester</h5>

        <div class="table-responsive">
          <table class="table table-striped table-bordered align-middle">
            <thead class="table-primary">
              <tr class="text-center">
                <th>No</th>
                <th>Kode Mata Kuliah</th>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th>Nilai</th>
              </tr>
            </thead>
            <tbody>
              <tr class="text-center">
                <td>1</td>
                <td>IF201</td>
                <td>Pemrograman Web</td>
                <td>3</td>
                <td>-</td>
              </tr>
              <tr class="text-center">
                <td>2</td>
                <td>IF202</td>
                <td>Basis Data</td>
                <td>3</td>
                <td>-</td>
              </tr>
              <tr class="text-center">
                <td>3</td>
                <td>IF203</td>
                <td>Struktur Data</td>
                <td>3</td>
                <td>-</td>
              </tr>
              <tr class="text-center">
                <td>4</td>
                <td>IF204</td>
                <td>Sistem Operasi</td>
                <td>3</td>
                <td>-</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="alert alert-info mt-4" role="alert">
          <i class="fa-solid fa-circle-info me-2"></i>
          Saat ini belum ada nilai yang masuk ke sistem. Silakan cek kembali setelah ujian semester selesai.
        </div>

        <div class="mt-4">
          <a href="{{ route('dashboard.mahasiswa') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
