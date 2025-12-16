@extends('mahasiswa.layouts.app')

@section('content')
<div class="container">
    <h2>Ranking Tempat PKL Terbaik</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Nama Perusahaan</th>
                <th>Skor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasil as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row['nama'] }}</td>
                    <td>{{ number_format($row['skor'], 4) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
