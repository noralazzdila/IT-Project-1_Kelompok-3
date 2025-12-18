<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Dosen;
use App\Models\Mahasiswa; // Import Mahasiswa model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Keep Storage for old file cleanup if any

class BimbinganController extends Controller
{
    public function index(Request $request)
    {
        $query = Bimbingan::where('user_id', Auth::id())->with('dosen');

        // Pencarian sederhana
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('topik_bimbingan', 'like', "%{$search}%");
        }

        // Filter status
        if ($request->filled('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        $bimbingans = $query->latest()->paginate(10)->withQueryString();

        return view('mahasiswa.bimbingan.index', compact('bimbingans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $dosens = Dosen::all();
        return view('mahasiswa.bimbingan.create', compact('dosens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'dosen_pembimbing' => 'required|exists:dosens,id',
            'topik_bimbingan' => 'required|string|max:255',
            'tanggal_bimbingan' => 'required|date',
        ]);

        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();

        if (!$mahasiswa) {
            return back()->withErrors(['msg' => 'Data mahasiswa tidak ditemukan untuk pengguna ini.']);
        }

        Bimbingan::create([
            'user_id' => Auth::id(),
            'mahasiswa_nama' => $mahasiswa->nama, // Add mahasiswa_nama
            'nim' => $mahasiswa->nim, // Add nim
            'dosen_pembimbing' => $request->dosen_pembimbing, // This is Dosen ID
            'topik_bimbingan' => $request->topik_bimbingan,
            'tanggal_bimbingan' => $request->tanggal_bimbingan,
            'status' => 'Menunggu',
            // 'file_path' is removed
        ]);

        return redirect()->route('mahasiswa.bimbingan.index')->with('success', 'Bimbingan berhasil ditambahkan.');
    }
}
