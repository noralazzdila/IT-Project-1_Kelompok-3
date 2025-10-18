<?php

namespace App\Http\Controllers;

use App\Models\Penguji;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class PengujiController extends Controller
{
    /**
     * Menampilkan daftar data penguji.
     */
    public function index(): View
    {
        $pengujis = Penguji::latest()->paginate(10);
        return view('penguji.index', compact('pengujis'));
    }

    /**
     * Menampilkan form untuk membuat data penguji baru.
     */
    public function create(): View
    {
        return view('penguji.create');
    }

    /**
     * Menyimpan data penguji baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'nama_penguji' => 'required|string|max:255',
            'nip'          => 'required|string|max:20|unique:penguji,nip',
            'email'        => 'required|email|max:255|unique:penguji,email',
            'no_telepon'   => 'required|string|max:15',
            'jabatan'      => 'required|string|max:100',
        ]);

        // Buat data baru
        Penguji::create($request->all());

        return redirect()->route('penguji.index')
                         ->with('success', 'Data Penguji berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu data penguji.
     */
    public function show(Penguji $penguji): View
    {
        return view('penguji.show', compact('penguji'));
    }

    /**
     * Menampilkan form untuk mengedit data penguji.
     */
    public function edit(Penguji $penguji): View
    {
        return view('penguji.edit', compact('penguji'));
    }

    /**
     * Memperbarui data penguji di database.
     */
    public function update(Request $request, Penguji $penguji): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'nama_penguji' => 'required|string|max:255',
            'nip'          => ['required', 'string', 'max:20', Rule::unique('penguji')->ignore($penguji->id)],
            'email'        => ['required', 'email', 'max:255', Rule::unique('penguji')->ignore($penguji->id)],
            'no_telepon'   => 'required|string|max:15',
            'jabatan'      => 'required|string|max:100',
        ]);

        // Update data
        $penguji->update($request->all());

        return redirect()->route('penguji.index')
                         ->with('success', 'Data Penguji berhasil diperbarui.');
    }

    /**
     * Menghapus data penguji dari database.
     */
    public function destroy(Penguji $penguji): RedirectResponse
    {
        $penguji->delete();

        return redirect()->route('penguji.index')
                         ->with('success', 'Data Penguji berhasil dihapus.');
    }
}
