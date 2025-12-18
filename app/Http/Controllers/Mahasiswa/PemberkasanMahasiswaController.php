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
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        if (! $mahasiswa) {
            return back()->withErrors(['msg' => 'Data mahasiswa tidak ditemukan']);
        }

        $pemberkasan = Pemberkasan::firstOrCreate(
            ['mahasiswa_id' => $mahasiswa->id],
            ['is_lengkap' => false, 'status' => 'Menunggu']
        );

        $validationRules = [
            'form_bimbingan_file' => 'nullable|mimes:pdf|max:5120',
            'sertifikat_file' => 'nullable|mimes:pdf|max:5120',
            'laporan_final_file' => 'nullable|mimes:pdf|max:5120',
            'type' => 'nullable|in:form_bimbingan,sertifikat,laporan_final', // Kept for existing modals
            'file' => 'nullable|mimes:pdf|max:5120', // Kept for existing modals
        ];

        // Only validate 'required' if no existing files
        if (
            empty($pemberkasan->form_bimbingan_path) &&
            empty($pemberkasan->sertifikat_path) &&
            empty($pemberkasan->laporan_final_path)
        ) {
            // For initial upload, ensure at least one file is present
            $validationRules['form_bimbingan_file'] = 'required_without_all:sertifikat_file,laporan_final_file|mimes:pdf|max:5120';
            $validationRules['sertifikat_file'] = 'required_without_all:form_bimbingan_file,laporan_final_file|mimes:pdf|max:5120';
            $validationRules['laporan_final_file'] = 'required_without_all:form_bimbingan_file,sertifikat_file|mimes:pdf|max:5120';
        }

        $validatedData = $request->validate($validationRules);

        // Handle form_bimbingan_file
        if ($request->hasFile('form_bimbingan_file')) {
            if ($pemberkasan->form_bimbingan_path) {
                Storage::disk('public')->delete($pemberkasan->form_bimbingan_path);
            }
            $pemberkasan->form_bimbingan_path = $request->file('form_bimbingan_file')->store('pemberkasan', 'public');
        }

        // Handle sertifikat_file
        if ($request->hasFile('sertifikat_file')) {
            if ($pemberkasan->sertifikat_path) {
                Storage::disk('public')->delete($pemberkasan->sertifikat_path);
            }
            $pemberkasan->sertifikat_path = $request->file('sertifikat_file')->store('pemberkasan', 'public');
        }

        // Handle laporan_final_file
        if ($request->hasFile('laporan_final_file')) {
            if ($pemberkasan->laporan_final_path) {
                Storage::disk('public')->delete($pemberkasan->laporan_final_path);
            }
            $pemberkasan->laporan_final_path = $request->file('laporan_final_file')->store('pemberkasan', 'public');
        }

        // --- Logic for single file upload from other modals (kept for backward compatibility) ---
        if ($request->hasFile('file') && $request->has('type')) {
            if ($request->type === 'form_bimbingan') {
                if ($pemberkasan->form_bimbingan_path) {
                    Storage::disk('public')->delete($pemberkasan->form_bimbingan_path);
                }
                $pemberkasan->form_bimbingan_path = $request->file('file')->store('pemberkasan', 'public');
            } elseif ($request->type === 'sertifikat') {
                if ($pemberkasan->sertifikat_path) {
                    Storage::disk('public')->delete($pemberkasan->sertifikat_path);
                }
                $pemberkasan->sertifikat_path = $request->file('file')->store('pemberkasan', 'public');
            } elseif ($request->type === 'laporan_final') {
                if ($pemberkasan->laporan_final_path) {
                    Storage::disk('public')->delete($pemberkasan->laporan_final_path);
                }
                $pemberkasan->laporan_final_path = $request->file('file')->store('pemberkasan', 'public');
            }
        }
        // --- End of single file upload logic ---

        // Update is_lengkap based on all three files being present
        $pemberkasan->is_lengkap = (bool) (
            $pemberkasan->form_bimbingan_path &&
            $pemberkasan->sertifikat_path &&
            $pemberkasan->laporan_final_path
        );

        // Status remains 'Menunggu' until changed by admin.
        // If it becomes fully complete, we can update the status automatically here,
        // but the user's request implies admin control.
        // For now, only set status to 'Menunggu' on initial creation, it won't change here.

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
