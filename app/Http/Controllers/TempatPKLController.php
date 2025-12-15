<?php

namespace App\Http\Controllers;

use App\Models\TempatPKL;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TempatPKLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TempatPKL::query();

        // Handle search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_perusahaan', 'like', '%' . $request->search . '%');
        }

        // Handle filter by reputation
        if ($request->has('reputasi_perusahaan') && $request->reputasi_perusahaan != '') {
            $query->where('reputasi_perusahaan', $request->reputasi_perusahaan);
        }

        $tempatpkl = $query->latest()->paginate(10);

        return view('tempatpkl.index', compact('tempatpkl'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tempatpkl.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'jarak_lokasi' => 'nullable|numeric',
            'reputasi_perusahaan' => 'required|string',
            'fasilitas' => 'required|string',
            'kesesuaian_program' => 'required|string',
            'lingkungan_kerja' => 'required|string',
        ]);

        // Create a new record
        TempatPKL::create($request->all());

        return redirect()->route('tempatpkl.index')
                         ->with('success', 'Data Tempat PKL berhasil ditambahkan.');

        
    }

    /**
     * Display the specified resource.
     */
    public function show(TempatPKL $tempatpkl)
    {
        return view('tempatpkl.show', compact('tempatpkl'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TempatPKL $tempatpkl)
    {
        return view('tempatpkl.edit', compact('tempatpkl'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TempatPKL $tempatpkl)
    {
        // Validate the request
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'jarak_lokasi' => 'nullable|numeric',
            'reputasi_perusahaan' => 'required|string',
            'fasilitas' => 'required|string',
            'kesesuaian_program' => 'required|string',
            'lingkungan_kerja' => 'required|string',
        ]);

        // Update the record
        $tempatpkl->update($request->all());

        return redirect()->route('tempatpkl.index')
                         ->with('success', 'Data Tempat PKL berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TempatPKL $tempatpkl)
    {
        // Delete the record
        $tempatpkl->delete();

        return redirect()->route('tempatpkl.index')
                         ->with('success', 'Data Tempat PKL berhasil dihapus.');
    }

    public function uploadPdf(Request $request, $id)
    {
        // 1. Validasi file
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:2048',
        ]);

        // 2. Ambil data mahasiswa/tempat PKL
        $tempatpkl = TempatPKL::findOrFail($id);

        // 3. Simpan file ke storage
        $file = $request->file('pdf');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/pdf', $filename);

        // 4. Simpan path ke database
        $tempatpkl->pdf_path = $path;
        $tempatpkl->save();

        // 5. Catat aktivitas di tabel activity_logs
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => Auth::user()->name . ' meng-upload PDF untuk ' . $tempatpkl->nama_perusahaan,
            'type' => 'upload_pdf',
        ]);

        // 6. Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'PDF berhasil di-upload!');
    }

}
