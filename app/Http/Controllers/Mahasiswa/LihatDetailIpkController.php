<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Nilai;

class LihatDetailIpkController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Ambil mahasiswa lewat relasi user
    $mahasiswa = $user->mahasiswa;

    // Ambil data nilai jika mahasiswa ada
    $nilai = $mahasiswa ? Nilai::where('mahasiswa_id', $mahasiswa->id)->first() : null;

    return view('mahasiswa.lihatdetailipk.index', compact('mahasiswa', 'nilai'));
}

}