@extends('koor-pkl.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="row g-3">
    <div class="col-md-3">
        <a href="#" class="text-decoration-none text-dark">
            <div class="card card-dashboard text-center p-3 shadow-sm">
                <i class="fa fa-user-graduate mb-2"></i>
                <h7>Mahasiswa Memenuhi Syarat PKL</h7>
                <h4>{{ $mahasiswaMemenuhiSyarat }}</h4>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="#" class="text-decoration-none text-dark">
            <div class="card card-dashboard text-center p-3 shadow-sm">
                <i class="fa fa-file-signature mb-2"></i>
                <h6>Proposal Yang Disetujui</h6>
                <h4>{{ $proposalDisetujui }}</h4>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="#" class="text-decoration-none text-dark">
            <div class="card card-dashboard text-center p-3 shadow-sm">
                <i class="fa fa-building-columns mb-2"></i>
                <h6>Tempat PKL Mahasiswa</h6>
                <h4>{{ $tempatAktif }}</h4>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="#" class="text-decoration-none text-dark">
            <div class="card card-dashboard text-center p-3 shadow-sm">
                <i class="fa fa-calendar-days mb-2"></i>
                <h6>Jumlah Seminar Yang Terjadwal</h6>
                <h4>{{ $seminarBulanIni }}</h4>
            </div>
        </a>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Aktivitas Terbaru</h6>
            </div>
            <div class="card-body scrollable-content">
                <ul class="custom-list">
                    @forelse ($aktivitas as $item)
                        <li>
                            @if ($item['type'] == 'bimbingan')
                                <i class="fas fa-chalkboard-teacher text-primary list-icon"></i>
                            @elseif ($item['type'] == 'proposal')
                                <i class="fas fa-file-alt text-success list-icon"></i>
                            @elseif ($item['type'] == 'pemberkasan')
                                <i class="fas fa-folder text-info list-icon"></i>
                            @else
                                <i class="fas fa-calendar-check text-warning list-icon"></i>
                            @endif
                            <div class="list-content">
                                <p><strong>{{ $item['desc'] }}</strong></p>
                                <small class="text-muted">{{ $item['time'] }}</small>
                            </div>
                        </li>
                    @empty
                        <li>
                            <div class="list-content">
                                <p>Tidak ada aktivitas terbaru.</p>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0">Jadwal Seminar </h6>
            </div>
            <div class="card-body scrollable-content">
                @forelse ($seminars as $seminar)
                <div class="seminar-entry">
                    <div class="student-info">
                        {{ $seminar->nama_mahasiswa ?? '-' }}
                        <small class="d-block">NIM: {{ $seminar->nim ?? '-' }}</small>
                    </div>
                    <p class="judul">"{{ $seminar->judul ?? 'Judul tidak tersedia' }}"</p>
                    <div class="seminar-details">
                        <p class="mb-1"><i class="fas fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($seminar->tanggal)->translatedFormat('l, d F Y') }}</p>
                        <p class="mb-1"><i class="fas fa-clock me-2"></i>{{ $seminar->jam_mulai }} - {{ $seminar->jam_selesai }}</p>
                        <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>{{ $seminar->ruang }}</p>
                    </div>
                    <hr class="my-2">
                    <div class="seminar-roles">
                        <p class="mb-1"><strong>Pembimbing:</strong> {{ $seminar->nama_pembimbing ?? '-' }}</p>
                        <p class="mb-0"><strong>Penguji:</strong> {{ $seminar->nama_penguji ?? '-' }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center p-4">
                    <p class="mb-0">Belum ada jadwal seminar.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection