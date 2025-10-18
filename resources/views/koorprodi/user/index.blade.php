@extends('koorprodi.layouts.app')

@section('title', 'Kelola User - Koordinator Prodi')

@section('header-title', 'Kelola User')

@section('content')
<div class="container mt-4 flex-grow-1">
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <h6 class="fw-bold">Daftar User</h6>
        <a href="{{ route('koorprodi.user.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah User
        </a>
    </div>

    <div class="card shadow-sm p-3">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role ?? 'User') }}</td>
                    <td>{{ $user->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('koorprodi.user.show', $user->id) }}" class="btn btn-sm btn-info">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('koorprodi.user.edit', $user->id) }}" class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('koorprodi.user.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection