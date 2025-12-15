<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NotifikasiPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('dashboard.index', ['user' => $user]);
    }

    public function kirimPengumuman()
{
    $mahasiswas = User::where('role', 'mahasiswa')->get();

    foreach ($mahasiswas as $mhs) {
        $mhs->notify(new NotifikasiPKL(
            'Pengumuman',
            'Ada informasi penting terkait PKL.',
            route('dashboard.mahasiswa')
        ));
    }

    return back()->with('success', 'Notifikasi terkirim');
}

    public function kirimNotifikasiSemuaRole()
{
    $users = User::whereIn('role', ['admin', 'dosen', 'mahasiswa'])->get();

    foreach ($users as $user) {
        $user->notify(new NotifikasiPKL(
            'Pengumuman Sistem PKL',
            'Ada informasi penting terkait PKL.',
            match ($user->role) {
                'admin'     => route('dashboard'),
                'dosen'     => route('dosen.dashboard'),
                'mahasiswa' => route('dashboard.mahasiswa'),
            }
        ));
    }

    return back()->with('success', 'Notifikasi berhasil dikirim ke semua role');
}

    public function testNotifikasiDashboard()
    {
        // ambil 1 mahasiswa untuk test
        $mahasiswa = User::where('role', 'mahasiswa')->first();

        $mahasiswa->notify(new NotifikasiPKL(
            'Test Notifikasi Dashboard PKL',
            'Ini notifikasi + email yang dikirim dari Dashboard PKL.',
            route('dashboard.mahasiswa')
        ));

        return back()->with('success', 'Notifikasi & email berhasil dikirim');
    }

}
