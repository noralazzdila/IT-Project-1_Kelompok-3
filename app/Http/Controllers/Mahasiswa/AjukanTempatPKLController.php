<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempatPKL;
use App\Models\Mahasiswa;
use App\Models\PengajuanPKL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AjukanTempatPKLController extends Controller
{
    /**
     * Tampilkan daftar pengajuan mahasiswa
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::where('mahasiswa_id', Auth::id())->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan!');
        }

        $pengajuan = PengajuanPKL::where('mahasiswa_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mahasiswa.tempatpkl.lihattempatpkl', compact('pengajuan'));
    }

    /**
     * Tampilkan halaman ajukan tempat PKL (multi-step)
     */
    public function create()
    {
        // Ambil user dan data mahasiswa yang sedang login
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // Cek jika data mahasiswa ada
        if (!$mahasiswa) {
            return redirect()->route('dashboard')->with('error', 'Data mahasiswa Anda tidak ditemukan. Harap hubungi administrator.');
        }

        // Ambil data nilai terakhir mahasiswa
        $nilai = $mahasiswa->nilai()->latest()->first();

        // Cek jika mahasiswa sudah pernah impor nilai
        if (!$nilai) {
            return redirect()->route('nilai.create')->with('warning', 'Anda harus mengimpor transkrip nilai Anda terlebih dahulu sebelum dapat mengajukan tempat PKL.');
        }

        // Cek status kelayakan mahasiswa
        if ($nilai->status !== 'Memenuhi Syarat') {
            $requirements = [
                'IPK'         => ['required' => '>= 2.50', 'actual' => number_format($nilai->ipk, 2), 'status' => $nilai->ipk >= 2.5],
                'Total SKS'   => ['required' => '>= 77', 'actual' => $nilai->total_sks, 'status' => $nilai->total_sks >= 77],
                'SKS Nilai D' => ['required' => '<= 6', 'actual' => $nilai->sks_d, 'status' => $nilai->sks_d <= 6],
                'Nilai E'     => ['required' => '= 0', 'actual' => $nilai->count_e, 'status' => $nilai->count_e == 0],
            ];
            
            $errorMessage = 'Anda belum memenuhi syarat untuk mengajukan PKL. Harap periksa kembali transkrip nilai Anda.';

            return redirect()->route('mahasiswa.lihatdetailipk.index')
                             ->with('error', $errorMessage)
                             ->with('requirements', $requirements);
        }

        // Jika semua syarat terpenuhi, tampilkan halaman pengajuan
        $pengajuan = PengajuanPKL::where('mahasiswa_id', Auth::id())->first();

        return view('mahasiswa.tempatpkl.ajukantempatpkl', compact('pengajuan'));
    }

    /**
     * Upload PDF transkrip mahasiswa
     */
    public function uploadPdf(Request $request)
{
    try {
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:2048',
        ]);

        $filePath = $request->file('pdf')->store('pdf_transkip', 'public');

        // Ambil mahasiswa terkait user login
        $mahasiswa = Auth::user()->mahasiswa; // pakai relasi
        if (!$mahasiswa) {
            Log::error('Data mahasiswa tidak ditemukan. Auth::id() = ' . Auth::id());
            return response()->json([
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan!'
            ], 400);
        }

        // Simpan pengajuan PKL
        $pengajuan = PengajuanPKL::updateOrCreate(
            ['mahasiswa_id' => Auth::id()],
            ['pdf_path' => $filePath, 'status' => 'uploaded']
        );

        return response()->json([
            'success' => true,
            'file_path' => $filePath,
            'message' => 'PDF berhasil di-upload!'
        ]);

    } catch (\Exception $e) {
        Log::error($e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Simpan data tempat PKL (tahap 2)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nama_pic' => 'nullable|string|max:255',
            'telepon_pic' => 'nullable|string|max:20',
            'pdf_path' => 'required|string'
        ]);

        $mahasiswa = Mahasiswa::where('mahasiswa_id', Auth::id())->first();

        // Update pengajuan mahasiswa tahap 2
        $pengajuan = PengajuanPKL::updateOrCreate(
            ['mahasiswa_id' => Auth::id()],
            [
                'nama_perusahaan' => $request->nama_perusahaan,
                'bidang' => $request->bidang,
                'alamat' => $request->alamat,
                'nama_pic' => $request->nama_pic,
                'telepon_pic' => $request->telepon_pic,
                'pdf_path' => $request->pdf_path,
                'status' => 'diproses'
            ]
        );

        return redirect()->route('tempatpkl.ajukantempatpkl')
            ->with('success', 'Pengajuan tempat PKL berhasil dikirim!');
    }
}
