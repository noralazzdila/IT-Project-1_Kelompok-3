<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;

class MahasiswaDosenController extends Controller
{
    /**
     * Menampilkan daftar seluruh dosen.
     */
    public function daftardosen()
    {
        $dosens = Dosen::all();
        return view('mahasiswa.dosen.daftardosen', compact('dosens'));
    }

    /**
     * Menampilkan daftar dosen pembimbing.
     */
    public function dosenpembimbing()
    {
        $pembimbing = Dosen::all(); // variabel ini harus sama dengan di Blade
        return view('mahasiswa.dosen.dosenpembimbing', compact('pembimbing'));
    }
}
