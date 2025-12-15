<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UploadProposalController extends Controller
{
    public function index()
    {
        $proposals = Proposal::where('nim', auth()->user()->nim)
            ->latest()
            ->get();

        return view('mahasiswa.proposal.upload', compact('proposals'));
    }

    public function store(Request $request)
{
    $user = Auth::user(); // user login

    // Cegah upload dobel
    $cek = Proposal::where('nim', $user->nim)->exists();
    if ($cek) {
        return back()->withErrors(['proposal' => 'Anda sudah pernah upload proposal']);
    }

    $request->validate([
        'judul_proposal' => 'required|string',
        'pembimbing' => 'required|string',
        'tempat_pkl' => 'required|string',
        'file_proposal' => 'required|mimes:pdf|max:5120',
    ]);

    $filePath = $request->file('file_proposal')
        ->store('proposals', 'public');

    Proposal::create([
        'nim' => $user->nim,
        'nama_mahasiswa' => $user->name,
        'judul_proposal' => $request->judul_proposal,
        'pembimbing' => $request->pembimbing,
        'tempat_pkl' => $request->tempat_pkl,
        'file_proposal' => $filePath,
        'status' => 'menunggu',
        'tanggal_pengajuan' => now(),
    ]);

    return redirect()
        ->route('mahasiswa.proposal.upload')
        ->with('success', 'Proposal berhasil diupload!');
}

    public function show($id)
{
    $proposal = Proposal::findOrFail($id);

    // Jika menggunakan policy
    $this->authorize('view', $proposal);

    return view('proposal.show', compact('proposal'));
}



}
