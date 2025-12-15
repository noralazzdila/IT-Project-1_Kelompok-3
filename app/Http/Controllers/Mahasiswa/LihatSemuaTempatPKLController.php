<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TempatPKL;

class LihatSemuaTempatPKLController extends Controller
{
    public function index()
    {
        $tempatPKL = TempatPKL::all(); // ambil semua data tempat PKL

        return view('mahasiswa.lihatsemua', compact('tempatPKL'));
    }
}