<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    // Tampilkan semua dosen
    public function index()
    {
        $dosens = Dosen::all();
        return view('dosen.dashboard', compact('dosens'));
    }

    // Form tambah dosen
    public function create()
    {
        return view('dosen.create');
    }

    // Simpan data dosen baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nidn' => 'required|unique:dosens,nidn',
            'email' => 'required|email|unique:dosens,email',
            'jurusan' => 'required|string|max:100',
        ]);

        Dosen::create($request->all());
        return redirect()->route('dosen.dashboard')->with('success', 'Data dosen berhasil ditambahkan.');
    }

    // Lihat detail dosen
    public function show($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('dosen.show', compact('dosen'));
    }

    // Form edit dosen
    public function edit($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('dosen.edit', compact('dosen'));
    }

    // Update data dosen
    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'nidn' => 'required|unique:dosens,nidn,' . $dosen->id,
            'email' => 'required|email|unique:dosens,email,' . $dosen->id,
            'jurusan' => 'required|string|max:100',
        ]);

        $dosen->update($request->all());
        return redirect()->route('dosen.dashboard')->with('success', 'Data dosen berhasil diperbarui.');
    }

    // Hapus data dosen
    public function destroy($id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->delete();
        return redirect()->route('dosen.dashboard')->with('success', 'Data dosen berhasil dihapus.');
    }
}
