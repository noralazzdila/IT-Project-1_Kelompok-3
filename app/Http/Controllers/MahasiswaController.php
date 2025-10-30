<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar;
use Carbon\Carbon;

class MahasiswaController extends Controller
{
    public function index()
    {
        return view('mahasiswa.mahasiswa');
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
