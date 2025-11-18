<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
=======
use App\Models\Seminar;
use Carbon\Carbon;
>>>>>>> 2f83dfbf7faf974a6ad9fb9857c241ed8e374a93

class MahasiswaController extends Controller
{
    public function index()
    {
        return view('mahasiswa.mahasiswa');
    }
<<<<<<< HEAD
=======
        public function indexMahasiswa()
    {
        
        return view('mahasiswa.tempatpkl.index');
    }

    public function jadwalSeminarIndex()
    {
        $seminars = Seminar::latest()->paginate(10);
        return view('mahasiswa.seminar.index', compact('seminars'));
    }
>>>>>>> 2f83dfbf7faf974a6ad9fb9857c241ed8e374a93
}
