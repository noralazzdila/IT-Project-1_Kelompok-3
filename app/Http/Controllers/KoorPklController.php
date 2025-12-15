<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use App\Models\Pemberkasan;
use App\Models\Proposal;
use App\Models\Seminar;
use App\Models\TempatPKL;
use App\Models\PengajuanPKL;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class KoorPklController extends Controller
{
    /**
     * Dashboard Koordinator PKL
     */
    public function index()
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Data dinamis dari database
        $totalMahasiswa = Mahasiswa::count();
        $tempatAktif = TempatPKL::count();
        $seminarBulanIni = Seminar::whereMonth('tanggal', now()->month)->count();

        // Menghitung mahasiswa yang memenuhi syarat (Query yang efisien)
        $mahasiswaMemenuhiSyarat = Nilai::where('ipk', '>=', 2.5)
                                     ->where('sks_d', '<=', 6)
                                     ->where('count_e', 0)
                                     ->where('total_sks', '>=', 77)
                                     ->count();

        // Menghitung proposal yang disetujui
        $proposalDisetujui = Proposal::where('status', 'Disetujui')->count();
        
        // Menghitung laporan yang menunggu validasi
        $laporanPending = PengajuanPKL::where('status', 'uploaded')->count();

        // Mengambil aktivitas terbaru dari log
        $aktivitas = ActivityLog::with('user')->latest()->take(10)->get();
        
        // Mengambil data seminar
        $seminars = Seminar::latest()->get();

        return view('koor-pkl.dashboard', compact(
            'user',
            'totalMahasiswa',
            'tempatAktif',
            'seminarBulanIni',
            'aktivitas',
            'seminars',
            'mahasiswaMemenuhiSyarat',
            'proposalDisetujui',
            'laporanPending'
        ));
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('koor-pkl.profil', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|max:2048', // max 2MB
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Validasi pengajuan PKL oleh koordinator (Setujui / Tolak / Diproses)
     */
    public function validasiPengajuan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:uploaded,diproses,diterima,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $pengajuan = PengajuanPKL::findOrFail($id);
        $pengajuan->status = $request->status;
        $pengajuan->catatan = $request->catatan;
        $pengajuan->save();

        // Log aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Koordinator ' . Auth::user()->name . ' ' . $request->status . ' pengajuan PKL mahasiswa: ' . $pengajuan->mahasiswa->name,
            'type' => 'pengajuan_validation',
        ]);

        return redirect()->back()->with('success', 'Pengajuan PKL berhasil diupdate.');
    }

    /**
     * Memberi nilai PKL mahasiswa
     */
    public function beriNilai(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
            'catatan' => 'nullable|string'
        ]);

        $pengajuan = PengajuanPKL::findOrFail($id);

        // Update status menjadi diterima
        $pengajuan->status = 'diterima';
        $pengajuan->save();

        // Simpan nilai PKL
        $pengajuan->nilaiPKL()->updateOrCreate(
            ['pengajuan_pkl_id' => $pengajuan->id],
            ['nilai' => $request->nilai, 'catatan' => $request->catatan]
        );

        // Log aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Koordinator ' . Auth::user()->name . ' memberi nilai PKL mahasiswa: ' . $pengajuan->mahasiswa->name,
            'type' => 'nilai_pkl',
        ]);

        return redirect()->back()->with('success', 'Pengajuan berhasil dinilai.');
    }

    /**
     * Validasi Proposal PKL
     */
    public function validateProposal(Request $request, Proposal $proposal)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $proposal->status = $request->status;
        $proposal->catatan = $request->catatan;
        $proposal->save();

        // Log aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Koordinator ' . Auth::user()->name . ' ' . $request->status . ' proposal: ' . $proposal->judul_proposal . ' oleh ' . $proposal->mahasiswa->name,
            'type' => 'proposal_validation',
        ]);

        return redirect()->back()->with('success', 'Status proposal berhasil diupdate.');
    }
}
