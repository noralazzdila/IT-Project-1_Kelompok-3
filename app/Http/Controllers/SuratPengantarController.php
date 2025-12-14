<?php

namespace App\Http\Controllers;

use App\Models\SuratPengantar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SuratPengantarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SuratPengantar::query();

        // Fitur pencarian
        if ($request->filled('search')) {
            $query->where('nama_mahasiswa', 'like', '%' . $request->search . '%')
                  ->orWhere('tempat_pkl', 'like', '%' . $request->search . '%');
        }

        // Fitur filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $suratPengantars = $query->latest()->paginate(10)->withQueryString();

        return view('suratpengantar.index', compact('suratPengantars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suratpengantar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nim' => 'required|string|max:20',
            'nama_mahasiswa' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'tempat_pkl' => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'tanggal_pengajuan' => 'required|date',
            'status' => ['required', Rule::in(['Menunggu', 'Diproses', 'Selesai'])],
            'file_surat' => 'nullable|file|mimes:pdf|max:5120', // Opsional saat create
            'catatan' => 'nullable|string',
        ]);

        if ($request->hasFile('file_surat')) {
            $filePath = $request->file('file_surat')->store('public/surat_pengantar');
            $validatedData['file_surat'] = str_replace('public/', '', $filePath);
        }

        SuratPengantar::create($validatedData);

        return redirect()->route('suratpengantar.index')->with('success', 'Surat Pengantar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratPengantar $suratpengantar)
    {
        return view('suratpengantar.show', compact('suratpengantar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratPengantar $suratpengantar)
    {
        return view('suratpengantar.edit', compact('suratpengantar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratPengantar $suratpengantar)
    {
        $validatedData = $request->validate([
            'nim' => 'required|string|max:20',
            'nama_mahasiswa' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'tempat_pkl' => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'tanggal_pengajuan' => 'required|date',
            'status' => ['required', Rule::in(['Menunggu', 'Diproses', 'Selesai'])],
            'file_surat' => 'nullable|file|mimes:pdf|max:5120',
            'catatan' => 'nullable|string',
        ]);

        if ($request->hasFile('file_surat')) {
            // Hapus file lama jika ada
            if ($suratpengantar->file_surat && Storage::exists('public/' . $suratpengantar->file_surat)) {
                Storage::delete('public/' . $suratpengantar->file_surat);
            }
            
            $filePath = $request->file('file_surat')->store('public/surat_pengantar');
            $validatedData['file_surat'] = str_replace('public/', '', $filePath);
        }

        $suratpengantar->update($validatedData);

        return redirect()->route('suratpengantar.index')->with('success', 'Surat Pengantar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratPengantar $suratpengantar)
    {
        // Hapus file dari storage
        if ($suratpengantar->file_surat && Storage::exists('public/' . $suratpengantar->file_surat)) {
            Storage::delete('public/' . $suratpengantar->file_surat);
        }
        
        $suratpengantar->delete();

        return redirect()->route('suratpengantar.index')->with('success', 'Surat Pengantar berhasil dihapus.');
    }
    public function createMahasiswa()
    {
       
        $submissions = SuratPengantar::where('nim', '')->latest()->get();

        return view('mahasiswa.suratpengantar.create', compact('submissions'));
    }

 
    public function storeMahasiswa(Request $request)
    {
        // Validasi, kolom 'status' sudah dihapus
        $validatedData = $request->validate([
            'nim' => 'required|string|max:20',
            'nama_mahasiswa' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'tempat_pkl' => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'tanggal_pengajuan' => 'required|date',
            'file_surat' => 'nullable|file|mimes:pdf|max:5120',
            'catatan' => 'nullable|string',
        ]);

        // Secara otomatis mengatur status menjadi 'Menunggu'
        $validatedData['status'] = 'Menunggu';

        if ($request->hasFile('file_surat')) {
            $filePath = $request->file('file_surat')->store('public/surat_pengantar');
            $validatedData['file_surat'] = str_replace('public/', '', $filePath);
        }

        SuratPengantar::create($validatedData);
        
        return redirect()->back()->with('success', 'Pengajuan surat pengantar berhasil dikirim!');
    }

    public function file(SuratPengantar $suratpengantar)
    {
        if (!$suratpengantar->file_surat || !Storage::exists('public/' . $suratpengantar->file_surat)) {
            abort(404);
        }

        return Storage::response('public/' . $suratpengantar->file_surat);
    }
}
