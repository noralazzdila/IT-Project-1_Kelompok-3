<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use App\Models\Pemberkasan;
use App\Models\Proposal;
use App\Models\Seminar;
use App\Models\TempatPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class KoorPklController extends Controller
{
    public function index()
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Data dinamis dari database
        $totalMahasiswa = Mahasiswa::count();
        $tempatAktif = TempatPKL::count(); // Asumsi semua tempat dihitung sebagai aktif
        $seminarBulanIni = Seminar::whereMonth('tanggal', now()->month)->count();

        // Menghitung mahasiswa yang memenuhi syarat
        $mahasiswaMemenuhiSyarat = Nilai::all()->filter(function ($nilai) {
            return $nilai->status === 'Memenuhi Syarat';
        })->count();

        // Menghitung proposal yang disetujui
        $proposalDisetujui = Proposal::where('status', 'Disetujui')->count();

        // Mengambil aktivitas terbaru
        $bimbingan = Bimbingan::latest()->take(5)->get()->map(function ($item) {
            return [
                'type' => 'bimbingan',
                'desc' => $item->mahasiswa_nama . ' telah bimbingan dengan ' . $item->dosen_pembimbing,
                'time' => $item->created_at->diffForHumans(),
            ];
        });

        $proposal = Proposal::latest()->take(5)->get()->map(function ($item) {
            return [
                'type' => 'proposal',
                'desc' => $item->nama_mahasiswa . ' mengajukan proposal baru.',
                'time' => $item->created_at->diffForHumans(),
            ];
        });

        $pemberkasan = Pemberkasan::latest()->take(5)->get()->map(function ($item) {
            return [
                'type' => 'pemberkasan',
                'desc' => $item->nama_mahasiswa . ' mengunggah berkas baru.',
                'time' => $item->created_at->diffForHumans(),
            ];
        });

        $seminar = Seminar::latest()->take(5)->get()->map(function ($item) {
            return [
                'type' => 'seminar',
                'desc' => 'Seminar untuk ' . $item->nama_mahasiswa . ' telah dijadwalkan.',
                'time' => $item->created_at->diffForHumans(),
            ];
        });

        $aktivitas = collect($bimbingan)->merge($proposal)->merge($pemberkasan)->merge($seminar)->sortByDesc('time')->take(5);


        // Mengambil semua data seminar, diurutkan berdasarkan tanggal terbaru
        $seminars = Seminar::latest()->get();

        return view('koor-pkl.dashboard', compact(
            'user',
            'totalMahasiswa',
            'tempatAktif',
            'seminarBulanIni',
            'aktivitas',
            'seminars',
            'mahasiswaMemenuhiSyarat',
            'proposalDisetujui' // Mengirim data ke view
        ));
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('koor-pkl.profil', compact('user'));
    }

    public function updateProfile(Request $request)
    {
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
}
