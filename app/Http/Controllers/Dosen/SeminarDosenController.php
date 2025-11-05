<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Seminar;

class SeminarDosenController extends Controller
{
    public function index()
{
    // Ambil data dengan pagination, misal 10 per halaman
    $seminars = Seminar::orderBy('tanggal', 'desc')->paginate(10);

    return view('dosen.seminar.indexdosen', compact('seminars'));
}


    public function show($id)
    {
        // Ambil satu data seminar berdasarkan ID
        $seminar = Seminar::findOrFail($id);

        // Kirim ke view showdosen.blade.php
        return view('dosen.seminar.showdosen', compact('seminar'));
    }
}
