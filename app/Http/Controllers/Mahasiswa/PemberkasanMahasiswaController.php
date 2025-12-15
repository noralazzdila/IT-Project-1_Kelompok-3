<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pemberkasan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PemberkasanMahasiswaController extends Controller
{
    public function index()
    {
        // Temukan mahasiswa yang terkait dengan user login
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();

        // Default empty collection for the list view
        $pemberkasans = collect();
        $pemberkasan = null;

        if ($mahasiswa) {
            // Provide both a collection and a singular item for compatibility with the view
            $pemberkasans = Pemberkasan::where('mahasiswa_id', $mahasiswa->id)->get();
            $pemberkasan = $pemberkasans->first();
        }

        return view('mahasiswa.pemberkasan.upload', compact('pemberkasans', 'pemberkasan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:form_bimbingan,sertifikat,laporan_final',
            'file' => 'required|mimes:pdf|max:5120'
        ]);

        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        if (! $mahasiswa) {
            return back()->withErrors(['msg' => 'Data mahasiswa tidak ditemukan']);
        }

        $pemberkasan = Pemberkasan::firstOrCreate(
            ['mahasiswa_id' => $mahasiswa->id],
            ['is_lengkap' => false]
        );

        $file = $request->file('file');
        $path = $file->store('pemberkasan', 'public');

        if ($request->type === 'form_bimbingan') {
            $pemberkasan->form_bimbingan_path = $path;
        } elseif ($request->type === 'sertifikat') {
            $pemberkasan->sertifikat_path = $path;
        } else {
            $pemberkasan->laporan_final_path = $path;
        }

        // cek kelengkapan
        $pemberkasan->is_lengkap = (bool) (
            $pemberkasan->form_bimbingan_path &&
            $pemberkasan->sertifikat_path &&
            $pemberkasan->laporan_final_path
        );

        $pemberkasan->save();

        return redirect()->route('mahasiswa.pemberkasan.upload')->with('success', 'Berkas berhasil diupload');
    }
    public function viewFile($type, $id)
    {
        // Ambil data pemberkasan
        $pemberkasan = Pemberkasan::findOrFail($id);

        // Tentukan path file berdasarkan tipe
        switch ($type) {
            case 'form_bimbingan':
                $filePath = $pemberkasan->form_bimbingan_path;
                break;
            case 'sertifikat':
                $filePath = $pemberkasan->sertifikat_path;
                break;
            case 'laporan_final':
                $filePath = $pemberkasan->laporan_final_path;
                break;
            default:
                abort(404);
        }

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        // Tampilkan file di browser
        $absolutePath = storage_path('app/public/' . $filePath);
        return response()->file($absolutePath);
    }
}
