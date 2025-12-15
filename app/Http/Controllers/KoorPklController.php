<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Seminar;
use App\Models\TempatPKL;
use App\Models\PengajuanPKL;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Proposal;
use Illuminate\Http\Request;

class KoorPklController extends Controller
{
    /**
     * Dashboard Koordinator PKL
     */
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        $tempatAktif = TempatPKL::count();
        $seminarBulanIni = Seminar::whereMonth('tanggal', now()->month)->count();
        $laporanPending = PengajuanPKL::where('status', 'uploaded')->count();

        $activities = ActivityLog::with('user')->latest()->take(10)->get();
        $seminars = Seminar::latest()->get();

        return view('koor-pkl.dashboard', compact(
            'totalMahasiswa',
            'tempatAktif',
            'seminarBulanIni',
            'laporanPending',
            'activities',
            'seminars'
        ));
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
            'user_id' => auth()->id(),
            'activity' => 'Koordinator ' . auth()->user()->name . ' ' . $request->status . ' pengajuan PKL mahasiswa: ' . $pengajuan->mahasiswa->name,
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
            'user_id' => auth()->id(),
            'activity' => 'Koordinator ' . auth()->user()->name . ' memberi nilai PKL mahasiswa: ' . $pengajuan->mahasiswa->name,
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
            'user_id' => auth()->id(),
            'activity' => 'Koordinator ' . auth()->user()->name . ' ' . $request->status . ' proposal: ' . $proposal->judul_proposal . ' oleh ' . $proposal->mahasiswa->name,
            'type' => 'proposal_validation',
        ]);

        return redirect()->back()->with('success', 'Status proposal berhasil diupdate.');
    }
}
