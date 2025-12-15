<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\TempatPKL;

class TempatPKLController extends Controller
{
    public function index()
{
    $tempatPKL = TempatPKL::all(); // ambil semua data tempat PKL

    return view('mahasiswa.tempatpkl.lihattempatpkl', compact('tempatPKL'));
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
            'user_id' => auth()->id(),
            'activity' => auth()->user()->name . ' meng-upload PDF untuk ' . $tempatpkl->nama_perusahaan,
            'type' => 'upload_pdf',
        ]);

        // 6. Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'PDF berhasil di-upload!');
    }

}

