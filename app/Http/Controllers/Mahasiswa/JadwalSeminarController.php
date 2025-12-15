<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use Illuminate\Http\Request;

class JadwalSeminarController extends Controller
{
    public function index()
    {
        // ambil semua seminar dengan pagination
        $seminars = Seminar::orderBy('tanggal', 'asc')->paginate(6);

        return view('mahasiswa.seminar.index', compact('seminars'));
    }

    public function show($id)
    {
        $seminar = Seminar::findOrFail($id);

        return view('mahasiswa.seminar.show', compact('seminar'));
    }
}
