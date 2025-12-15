<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Notifications\NotifikasiPKL;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
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

        return view('bimbingan.index', compact('bimbingans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('bimbingan.create');
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
        'catatan'           => 'nullable|string',
    ]);

    // Simpan bimbingan
    $bimbingan = Bimbingan::create([
        'user_id'           => Auth::id(), 
        'mahasiswa_nama'    => $request->mahasiswa_nama,
        'nim'               => $request->nim,
        'dosen_pembimbing'  => $request->dosen_pembimbing,
        'tanggal_bimbingan' => $request->tanggal_bimbingan,
        'topik_bimbingan'   => $request->topik_bimbingan,
        'catatan'           => $request->catatan,
        'status'            => 'Menunggu', // Default status
    ]);

    // Ambil user dosen
    $dosen = User::where('name', $request->dosen_pembimbing)->first();

    // KIRIM NOTIFIKASI 🔔 ke Dosen
    if ($dosen) {
        $dosen->notify(new NotifikasiPKL(
            'Permintaan Bimbingan Baru',
            'Mahasiswa ' . $request->mahasiswa_nama . ' mengajukan permintaan bimbingan.',
            route('bimbingan.index')
        ));
    }

    // Redirect
    return redirect()->route('bimbingan.index')
        ->with('success', 'Permintaan bimbingan berhasil diajukan & notifikasi telah dikirim ke dosen.');
}


    /**
     * Display the specified resource.
     */
    public function show(Bimbingan $bimbingan): View
    {
        return view('bimbingan.show', compact('bimbingan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bimbingan $bimbingan): View
    {
        return view('bimbingan.edit', compact('bimbingan'));
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
            'catatan'           => 'nullable|string',
            'status'            => 'required|in:Menunggu,Disetujui,Revisi',
        ]);

        $bimbingan->update($request->all());

        return redirect()->route('bimbingan.index')
                         ->with('success', 'Data Bimbingan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bimbingan $bimbingan): RedirectResponse
    {
        $bimbingan->delete();

        return redirect()->route('bimbingan.index')
                         ->with('success', 'Data Bimbingan berhasil dihapus.');
    }

}

