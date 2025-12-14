@extends('dosen.layouts.app')

@section('title', 'Detail Nilai - Dosen')

@section('header-title', 'Detail Nilai Mahasiswa')

@section('content')
        <div class="container mt-4 flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold mb-0">Informasi Nilai: {{ $nilai->mahasiswa->nama ?? '-' }}</h6>
                    <small class="text-muted">NIM: {{ $nilai->mahasiswa->nim ?? '-' }}</small>
                </div>
                <a href="{{ route('dosen.nilai.indexdosen') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card shadow-sm p-3">
                <div class="row p-3 mb-3 border rounded bg-light">
                    <div class="col-md-4">
                        <strong>IPK:</strong> {{ number_format($nilai->ipk, 2) }}
                    </div>
                    <div class="col-md-4">
                        <strong>Total SKS:</strong> {{ $nilai->total_sks }}
                    </div>
                    <div class="col-md-4">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $nilai->status_color }}">{{ $nilai->status }}</span>
                    </div>
                </div>

                <h6 class="fw-bold mt-3">
                    Transkrip Nilai
                    <small class="text-muted fw-normal">
                        @if ($nilai->pdf_path)
                            (sumber: {{ basename($nilai->pdf_path) }})
                        @else
                            (sumber: {{ $nilai->sheet_name ?? 'Google Sheet' }})
                        @endif
                    </small>
                </h6>

                @if ($nilai->pdf_path)
                    <div class="mt-3">
                        <iframe src="{{ route('nilai.pdf', ['id' => $nilai->id]) }}" width="100%" height="600px"></iframe>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-2">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Mata Kuliah</th>
                                    <th>Nilai</th>
                                    <th>A.m</th>
                                    <th>SKS</th>
                                    <th>Bobot</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rows as $i => $row)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $row['kode'] }}</td>
                                    <td>{{ $row['mata_kuliah'] }}</td>
                                    <td>{{ $row['nilai'] }}</td>
                                    <td>{{ $row['am'] }}</td>
                                    <td>{{ $row['sks'] }}</td>
                                    <td>{{ $row['bobot'] }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        Data transkrip tidak dapat ditampilkan. Pastikan sumber data (PDF) valid.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
@endsection