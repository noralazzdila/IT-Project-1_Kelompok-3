<?php

namespace App\Http\Controllers\Dosen;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;

class ProposalDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Proposal::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_mahasiswa', 'like', "%{$search}%")
                  ->orWhere('judul_proposal', 'like', "%{$search}%");
        }

        if ($request->filled('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        $proposals = $query->latest()->paginate(10)->withQueryString();

        return view('dosen.proposal.indexdosen', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dosen.proposal.createdosen');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nim' => 'required|string|max:20',
            'nama_mahasiswa' => 'required|string|max:255',
            'judul_proposal' => 'required|string|max:255',
            'pembimbing' => 'required|string|max:255',
            'tempat_pkl' => 'required|string|max:255',
            'tanggal_pengajuan' => 'required|date',
            'status' => 'required|in:Diterima,Ditolak,Revisi',
            'catatan' => 'nullable|string',
            // 'file_proposal' => 'required|file|mimes:pdf|max:2048', // Example validation for file
        ]);

        // Handle file upload logic here if needed
        
        Proposal::create($request->all());

        return redirect()->route('dosen.proposal.indexdosen')
                         ->with('success', 'Data Proposal berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proposal $proposal): View
    {
        return view('dosen.proposal.showdosen', compact('proposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proposal $proposal): View
    {
        return view('dosen.proposal.editdosen', compact('proposal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proposal $proposal): RedirectResponse
    {
        $request->validate([
            'nim' => 'required|string|max:20',
            'nama_mahasiswa' => 'required|string|max:255',
            'judul_proposal' => 'required|string|max:255',
            'pembimbing' => 'required|string|max:255',
            'tempat_pkl' => 'required|string|max:255',
            'tanggal_pengajuan' => 'required|date',
            'status' => 'required|in:Diterima,Ditolak,Revisi',
            'catatan' => 'nullable|string',
        ]);

        $proposal->update($request->all());

        return redirect()->route('dosen.proposal.indexdosen')
                         ->with('success', 'Data Proposal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proposal $proposal): RedirectResponse
    {
        // Handle file deletion logic here if needed

        $proposal->delete();

        return redirect()->route('dosen.proposal.indexdosen')
                         ->with('success', 'Data Proposal berhasil dihapus.');
    }
}
