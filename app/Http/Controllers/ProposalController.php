<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NotifikasiPKL;
use App\Models\User;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Proposal::with('dosen')->latest();

        // Pencarian berdasarkan nama mahasiswa atau judul proposal
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_mahasiswa', 'like', '%' . $request->search . '%')
                  ->orWhere('judul_proposal', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $proposals = $query->paginate(10);

        return view('proposal.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proposal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nim' => 'required|string|max:20|unique:proposals,nim',
            'nama_mahasiswa' => 'required|string|max:255',
            'judul_proposal' => 'required|string|max:255',
            'pembimbing' => 'required|string|max:255',
            'tempat_pkl' => 'required|string|max:255',
            'file_proposal' => 'required|file|mimes:pdf|max:5120', // Max 5MB
            'tanggal_pengajuan' => 'required|date',
            'status' => ['required', Rule::in(['Menunggu', 'Disetujui', 'Ditolak'])],
            'catatan' => 'nullable|string',
            
        ]);

        // Handle file upload
        if ($request->hasFile('file_proposal')) {
            $filePath = $request->file('file_proposal')->store('public/proposals');
            // Simpan path yang relatif terhadap storage/app
            $validatedData['file_proposal'] = str_replace('public/', '', $filePath);
        }

        Proposal::create($validatedData);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => Auth::user()->name . ' mengajukan proposal PKL.',
            'type' => 'proposal_upload',
        ]);


        return redirect()->route('proposal.index')->with('success', 'Proposal PKL berhasil ditambahkan.');

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Proposal $proposal)
    {
        return view('proposal.show', compact('proposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proposal $proposal)
    {
        return view('proposal.edit', compact('proposal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proposal $proposal)
    {
        $validatedData = $request->validate([
            'nim' => ['required', 'string', 'max:20', Rule::unique('proposals')->ignore($proposal->id)],
            'nama_mahasiswa' => 'required|string|max:255',
            'judul_proposal' => 'required|string|max:255',
            'pembimbing' => 'required|string|max:255',
            'tempat_pkl' => 'required|string|max:255',
            'file_proposal' => 'nullable|file|mimes:pdf|max:5120', // Opsional saat update
            'tanggal_pengajuan' => 'required|date',
            'status' => ['required', Rule::in(['Menunggu', 'Disetujui', 'Ditolak'])],
            'catatan' => 'nullable|string',
        ]);

        // Handle file upload if a new file is provided
        if ($request->hasFile('file_proposal')) {
            // Hapus file lama jika ada
            if ($proposal->file_proposal && Storage::exists('public/' . $proposal->file_proposal)) {
                Storage::delete('public/' . $proposal->file_proposal);
            }
            
            $filePath = $request->file('file_proposal')->store('public/proposals');
            $validatedData['file_proposal'] = str_replace('public/', '', $filePath);
        }

        $proposal->update($validatedData);

        return redirect()->route('proposal.index')->with('success', 'Proposal PKL berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proposal $proposal)
    {
        // Hapus file proposal dari storage
        if ($proposal->file_proposal && Storage::exists('public/' . $proposal->file_proposal)) {
            Storage::delete('public/' . $proposal->file_proposal);
        }
        
        $proposal->delete();

        return redirect()->route('proposal.index')->with('success', 'Proposal PKL berhasil dihapus.');
    }

    //MHS
    public function createMahasiswa()
    {
        // Di aplikasi nyata, Anda akan menggunakan ID user yang sedang login.
        // $user = Auth::user();
        // $proposals = Proposal::where('nim', $user->nim)->latest()->get();
        
        // Untuk sekarang, kita gunakan NIM statis sebagai contoh
        // Berdasarkan skema database Anda, NIM bersifat unik, jadi kita pakai first() atau get()
        $proposals = Proposal::where('nim', '2062201015')->latest()->get();

        return view('mahasiswa.proposal.upload', compact('proposals'));
    }

    /**
     * Menyimpan proposal baru dari mahasiswa.
     */
    public function storeMahasiswa(Request $request)
    {
        // Validasi, kolom 'status' dihapus dari form
        $validatedData = $request->validate([
            'nim' => 'required|string|max:20|unique:proposals,nim', // NIM harus unik berdasarkan skema Anda
            'nama_mahasiswa' => 'required|string|max:255',
            'judul_proposal' => 'required|string|max:255',
            'pembimbing' => 'required|string|max:255',
            'tempat_pkl' => 'required|string|max:255',
            'file_proposal' => 'required|file|mimes:pdf|max:5120',
            'tanggal_pengajuan' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        // Secara otomatis mengatur status menjadi 'Menunggu'
        $validatedData['status'] = 'Menunggu';

        // Handle file upload
        if ($request->hasFile('file_proposal')) {
            $filePath = $request->file('file_proposal')->store('public/proposals');
            $validatedData['file_proposal'] = str_replace('public/', '', $filePath);
        }

        Proposal::create($validatedData);
        
        return redirect()->back()->with('success', 'Proposal berhasil di-upload! Harap tunggu review dari Koordinator.');
    }

    public function file(Proposal $proposal)
    {
        if (!$proposal->file_proposal || !Storage::exists('public/' . $proposal->file_proposal)) {
            abort(404);
        }

        return Storage::response('public/' . $proposal->file_proposal);
    }
    public function setujui($proposalId)
    {
        $proposal = Proposal::findOrFail($proposalId);

        // 1️Update status proposal
        $proposal->update([
            'status' => 'disetujui'
        ]);

        // 2️Ambil mahasiswa pemilik proposal
        $user = $proposal->mahasiswa; // relasi ke User

        // 3️KIRIM NOTIFIKASI 🔔
        $user->notify(new NotifikasiPKL(
            'Proposal Disetujui',
            'Proposal PKL Anda telah disetujui oleh dosen pembimbing.',
            route('mahasiswa.proposal.index')
        ));

        return back()->with('success', 'Proposal disetujui & notifikasi dikirim');
    }

}