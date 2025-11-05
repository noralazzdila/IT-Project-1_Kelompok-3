<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\DataMahasiswa;
use Illuminate\Http\Request;

class DataMahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = DataMahasiswa::paginate(10);
        return view('dosen.datamahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('dosen.datamahasiswa.createdosen');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:data_mahasiswas,nim', // pastikan table name benar
            'prodi' => 'required',
            'tahun_angkatan' => 'required|digits:4',
            'email' => 'required|email',
            'no_hp' => 'required',
        ]);

        DataMahasiswa::create($request->all());

        return redirect()->route('dosen.datamahasiswa.index')
                         ->with('success', 'Data mahasiswa berhasil ditambahkan!');
    }

    public function edit($id)
{
    $datamahasiswa = \App\Models\DataMahasiswa::findOrFail($id);
    return view('dosen.datamahasiswa.editdosen', compact('datamahasiswa'));
}


    public function update(Request $request, $id)
    {
        $datamahasiswa = DataMahasiswa::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswa,nim,' . $id, // unik tapi exclude record ini
            'prodi' => 'required',
            'tahun_angkatan' => 'required|digits:4',
            'email' => 'required|email',
            'no_hp' => 'required',
        ]);

        $datamahasiswa->update($request->all());

        return redirect()->route('dosen.datamahasiswa.index')
                         ->with('success', 'Data mahasiswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        $datamahasiswa = DataMahasiswa::findOrFail($id);
        $datamahasiswa->delete();

        return redirect()->route('dosen.datamahasiswa.index')
                         ->with('success', 'Data mahasiswa berhasil dihapus!');
    }

    public function show($id)
{
    $datamahasiswa = DataMahasiswa::findOrFail($id);
    return view('dosen.datamahasiswa.showdosen', compact('datamahasiswa'));
}


}
