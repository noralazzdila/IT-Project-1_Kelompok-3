<?php

namespace App\Http\Controllers\Dosen;

use App\Models\Bimbingan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

class BimbinganDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Bimbingan::query();

        // Fitur pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('mahasiswa_nama', 'like', "%{$search}%")
                  ->orWhere('dosen_pembimbing', 'like', "%{$search}%");
            });
        }

        // Fitur filter status
        if ($request->filled('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        $bimbingans = $query->latest()->paginate(10)->withQueryString();

        return view('dosen.bimbingan.indexdosen', compact('bimbingans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dosen.bimbingan.createdosen');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'mahasiswa_nama'    => 'required|string|max:255',
            'nim'               => 'required|string|max:20',
            'dosen_pembimbing'  => 'required|string|max:255',
            'tanggal_bimbingan' => 'required|date',
            'topik_bimbingan'   => 'required|string|max:255',
            'catatan'           => 'required|string',
            'status'            => 'required|in:Menunggu,Disetujui,Revisi',
        ]);

        Bimbingan::create($request->all());

        return redirect()->route('dosen.bimbingan.indexdosen')
                         ->with('success', 'Data Bimbingan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bimbingan $bimbingan): View
    {
        return view('dosen.bimbingan.showdosen', compact('bimbingan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bimbingan $bimbingan): View
    {
        return view('dosen.bimbingan.editdosen', compact('bimbingan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bimbingan $bimbingan): RedirectResponse
    {
        $request->validate([
            'mahasiswa_nama'    => 'required|string|max:255',
            'nim'               => 'required|string|max:20',
            'dosen_pembimbing'  => 'required|string|max:255',
            'tanggal_bimbingan' => 'required|date',
            'topik_bimbingan'   => 'required|string|max:255',
            'catatan'           => 'required|string',
            'status'            => 'required|in:Menunggu,Disetujui,Revisi',
        ]);

        $bimbingan->update($request->all());

        return redirect()->route('dosen.bimbingan.indexdosen')
                         ->with('success', 'Data Bimbingan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bimbingan $bimbingan): RedirectResponse
    {
        $bimbingan->delete();

        return redirect()->route('dosen.bimbingan.indexdosen')
                         ->with('success', 'Data Bimbingan berhasil dihapus.');
    }
}

