<?php

namespace App\Http\Controllers;

use App\Models\DataMahasiswa;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class DataMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = DataMahasiswa::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $mahasiswas = $query->latest()->paginate(10)->withQueryString();
        // Mengubah path view ke 'datamahasiswa.index'
        return view('datamahasiswa.index', compact('mahasiswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Mengubah path view ke 'datamahasiswa.create'
        return view('datamahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nim'               => 'required|string|max:20|unique:mahasiswa,nim',
            'nama'              => 'required|string|max:255',
            'jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'     => 'required|date',
            'prodi'             => 'required|string|max:100',
            'kelas'             => 'required|string|max:50',
            'tahun_angkatan'    => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'dosen_pembimbing'  => 'required|string|max:255',
            'tempat_pkl'        => 'required|string|max:255',
            'status_pkl'        => 'required|in:Belum Mulai,Sedang PKL,Selesai',
            'no_hp'             => 'required|string|max:15',
            'email'             => 'required|email|max:255|unique:mahasiswa,email',
        ]);

        DataMahasiswa::create($request->all());

        return redirect()->route('datamahasiswa.index')
                         ->with('success', 'Data Mahasiswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataMahasiswa $datamahasiswa): View
    {
        // Mengubah path view ke 'datamahasiswa.show'
        return view('datamahasiswa.show', compact('datamahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataMahasiswa $datamahasiswa): View
    {
        // Mengubah path view ke 'datamahasiswa.edit'
        return view('datamahasiswa.edit', compact('datamahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataMahasiswa $datamahasiswa): RedirectResponse
    {
        $request->validate([
            'nim'               => ['required','string','max:20', Rule::unique('mahasiswa')->ignore($datamahasiswa->id)],
            'nama'              => 'required|string|max:255',
            'jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'     => 'required|date',
            'prodi'             => 'required|string|max:100',
            'kelas'             => 'required|string|max:50',
            'tahun_angkatan'    => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'dosen_pembimbing'  => 'required|string|max:255',
            'tempat_pkl'        => 'required|string|max:255',
            'status_pkl'        => 'required|in:Belum Mulai,Sedang PKL,Selesai',
            'no_hp'             => 'required|string|max:15',
            'email'             => ['required','email','max:255', Rule::unique('mahasiswa')->ignore($datamahasiswa->id)],
        ]);

        $datamahasiswa->update($request->all());

        return redirect()->route('datamahasiswa.index')
                         ->with('success', 'Data Mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataMahasiswa $datamahasiswa): RedirectResponse
    {
        $datamahasiswa->delete();

        return redirect()->route('datamahasiswa.index')
                         ->with('success', 'Data Mahasiswa berhasil dihapus.');
    }
}

