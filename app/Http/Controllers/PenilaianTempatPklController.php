<?php

namespace App\Http\Controllers;

use App\Models\PenilaianTempatPkl;
use App\Models\TempatPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianTempatPklController extends Controller
{
    /**
     * Tampilkan daftar tempat PKL untuk dinilai
     */
    public function index()
    {
        // Ambil semua tempat PKL yang sudah disetujui
        $tempatPkls = TempatPKL::latest()
            ->paginate(12);

        // Ambil penilaian yang sudah dibuat user ini
        $penilaianUser = PenilaianTempatPkl::where('mahasiswa_id', Auth::id())
            ->pluck('tempat_pkl_id')
            ->toArray();

        return view('mahasiswa.penilaian.index', compact('tempatPkls', 'penilaianUser'));
    }

    /**
     * Tampilkan form penilaian untuk tempat PKL tertentu
     */
    public function create($tempatPklId)
    {
        $tempatPkl = TempatPKL::findOrFail($tempatPklId);

        // Cek apakah user sudah pernah menilai tempat ini
        $sudahDinilai = PenilaianTempatPkl::where('mahasiswa_id', Auth::id())
            ->where('tempat_pkl_id', $tempatPklId)
            ->exists();

        if ($sudahDinilai) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda sudah pernah menilai tempat PKL ini.');
        }

        return view('mahasiswa.penilaian.create', compact('tempatPkl'));
    }

    /**
     * Simpan penilaian
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tempat_pkl_id' => 'required|exists:tempat_pkl,id',
            'nama_tempat' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jarak' => 'required|numeric|min:0',
            'fasilitas' => 'required|integer|min:1|max:5',
            'program_magang' => 'required|integer|min:1|max:5',
            'reputasi' => 'required|integer|min:1|max:5',
            'kondisi_lingkungan' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        // Cek apakah sudah pernah menilai
        $exists = PenilaianTempatPkl::where('mahasiswa_id', Auth::id())
            ->where('tempat_pkl_id', $request->tempat_pkl_id)
            ->exists();

        if ($exists) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda sudah pernah menilai tempat PKL ini.');
        }

        // Simpan penilaian
        PenilaianTempatPkl::create([
            'mahasiswa_id' => Auth::id(),
            'tempat_pkl_id' => $validated['tempat_pkl_id'],
            'nama_tempat' => $validated['nama_tempat'],
            'alamat' => $validated['alamat'],
            'jarak' => $validated['jarak'],
            'fasilitas' => $validated['fasilitas'],
            'program_magang' => $validated['program_magang'],
            'reputasi' => $validated['reputasi'],
            'kondisi_lingkungan' => $validated['kondisi_lingkungan'],
            'komentar' => $validated['komentar'] ?? null,
        ]);

        return redirect()->route('penilaian.index')
            ->with('success', 'Terima kasih! Penilaian Anda telah berhasil disimpan.');
    }

    /**
     * Lihat detail penilaian yang sudah dibuat
     */
    public function show($id)
    {
        $penilaian = PenilaianTempatPkl::where('mahasiswa_id', Auth::id())
            ->findOrFail($id);

        return view('mahasiswa.penilaian.show', compact('penilaian'));
    }

    /**
     * Edit penilaian
     */
    public function edit($id)
    {
        $penilaian = PenilaianTempatPkl::where('mahasiswa_id', Auth::id())
            ->findOrFail($id);

        return view('mahasiswa.penilaian.edit', compact('penilaian'));
    }

    /**
     * Update penilaian
     */
    public function update(Request $request, $id)
    {
        $penilaian = PenilaianTempatPkl::where('mahasiswa_id', Auth::id())
            ->findOrFail($id);

        $validated = $request->validate([
            'nama_tempat' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jarak' => 'required|numeric|min:0',
            'fasilitas' => 'required|integer|min:1|max:5',
            'program_magang' => 'required|integer|min:1|max:5',
            'reputasi' => 'required|integer|min:1|max:5',
            'kondisi_lingkungan' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $penilaian->update($validated);

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil diperbarui.');
    }
}