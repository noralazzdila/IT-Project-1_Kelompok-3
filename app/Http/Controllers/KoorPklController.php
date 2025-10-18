<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Seminar;
use App\Models\TempatPKL;
use Illuminate\Http\Request;

class KoorPklController extends Controller
{
    public function index()
    {
        // Data dinamis dari database
        $totalMahasiswa = Mahasiswa::count();
        $tempatAktif = TempatPKL::count(); // Asumsi semua tempat dihitung sebagai aktif
        $seminarBulanIni = Seminar::whereMonth('tanggal', now()->month)->count();
        $laporanPending = 23; // Data statis

        $aktivitas = [
            ['type' => 'bimbingan', 'desc' => 'Ahmad Rizki telah menyelesaikan sesi bimbingan dengan dosen pembimbing', 'time' => '2 jam yang lalu'],
            ['type' => 'nilai', 'desc' => 'Siti Nurhaliza mendapat nilai 85 untuk laporan PKL', 'time' => '4 jam yang lalu'],
            ['type' => 'dokumen', 'desc' => 'Budi Santoso mengunggah laporan akhir PKL', 'time' => '6 jam yang lalu'],
            ['type' => 'seminar', 'desc' => 'Seminar Dijadwalkan', 'time' => ''],
        ];

        // Mengambil semua data seminar, diurutkan berdasarkan tanggal terbaru
        $seminars = Seminar::latest()->get();

        return view('koor-pkl.dashboard', compact(
            'totalMahasiswa',
            'tempatAktif',
            'seminarBulanIni',
            'laporanPending',
            'aktivitas',
            'seminars' // Mengirim data seminar ke view
        ));
    }
}
