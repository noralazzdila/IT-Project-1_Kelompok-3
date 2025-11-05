<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Penting untuk enkripsi password

class UserDosenController extends Controller
{
    /**
     * Menampilkan daftar semua user.
     */
    public function index()
    {
        // Ganti User::all() dengan model yang sesuai jika perlu (misal: Dosen::all())
        $users = User::all();
        return view('dosen.user.indexdosen', ['users' => $users]);
    }

    /**
     * Menampilkan form untuk membuat user baru.
     */
    public function create()
    {
        // Pastikan nama view ini sudah benar
        return view('dosen.user.createdosen');
    }

    /**
     * Menyimpan data user baru dari form ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'status' => 'required|string',
        ]);

        // 2. Buat record baru di database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password selalu di-enkripsi
            'role' => $request->role,
            'status' => $request->status,
            // 'identifier' => $request->identifier, // Aktifkan baris ini jika Anda punya kolom 'identifier' di tabel 'users'
        ]);

        // 3. Kembali ke halaman daftar user dengan pesan sukses
        return redirect()->route('dosen.user.index')
                         ->with('success', 'User baru berhasil ditambahkan.');
    }

    // Method lain seperti edit, update, destroy bisa ditambahkan di sini
    public function show($id)
    {
        // Cari user di database berdasarkan ID yang dikirim dari URL.
        // findOrFail akan otomatis menampilkan halaman 404 jika ID tidak ditemukan.
        $user = User::findOrFail($id);

        // Kirim data user yang ditemukan ke view 'showdosen'
        return view('dosen.user.showdosen', ['user' => $user]);
    }
}

