<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar;

class MahasiswaController extends Controller
{
    public function index()
    {
        $seminars = Seminar::where('tanggal', '>=', now()->toDateString())
                            ->orderBy('tanggal')
                            ->orderBy('jam_mulai')
                            ->get();

        return view('mahasiswa.mahasiswa', compact('seminars'));
    }
        public function indexMahasiswa()
    {
        
        return view('mahasiswa.tempatpkl.index');
    }

    public function jadwalSeminarIndex()
    {
        $seminars = Seminar::latest()->paginate(10);
        return view('mahasiswa.seminar.index', compact('seminars'));
    }
}
