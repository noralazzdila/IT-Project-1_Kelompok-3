<?php

namespace App\Http\Controllers\Dosen;

use App\Models\SuratPengantar;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

class SuratPengantarDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = SuratPengantar::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_mahasiswa', 'like', "%{$search}%")
                  ->orWhere('tempat_pkl', 'like', "%{$search}%");
        }

        if ($request->filled('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        $suratpengantars = $query->latest()->paginate(10)->withQueryString();

        return view('dosen.suratpengantar.indexdosen', compact('suratpengantars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dosen.suratpengantar.createdosen');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nim' => 'required|string|max:20',
            'nama_mahasiswa' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'tempat_pkl' => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'tanggal_pengajuan' => 'required|date',
            'status' => 'required|in:Diterima,Ditolak,Revisi',
            'catatan' => 'nullable|string',
        ]);

        SuratPengantar::create($request->all());

        return redirect()->route('dosen.suratpengantar.indexdosen')
                         ->with('success', 'Data Surat Pengantar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratPengantar $suratpengantar): View
    {
        return view('dosen.suratpengantar.showdosen', compact('suratpengantar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratPengantar $suratpengantar): View
    {
        return view('dosen.suratpengantar.editdosen', compact('suratpengantar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratPengantar $suratpengantar): RedirectResponse
    {
        $request->validate([
            'nim' => 'required|string|max:20',
            'nama_mahasiswa' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'tempat_pkl' => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'tanggal_pengajuan' => 'required|date',
            'status' => 'required|in:Diterima,Ditolak,Revisi',
            'catatan' => 'nullable|string',
        ]);

        $suratpengantar->update($request->all());

        return redirect()->route('dosen.suratpengantar.indexdosen')
                         ->with('success', 'Data Surat Pengantar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratPengantar $suratpengantar): RedirectResponse
    {
        $suratpengantar->delete();

        return redirect()->route('dosen.suratpengantar.indexdosen')
                         ->with('success', 'Data Surat Pengantar berhasil dihapus.');
    }
}
