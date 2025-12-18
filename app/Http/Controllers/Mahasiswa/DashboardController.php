<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\TempatPKL;
use App\Models\SawResult;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard mahasiswa dengan Top 5 Tempat PKL
     */
    public function index()
    {
        $mahasiswa = Auth::user();
        
        // Ambil Top 5 Tempat PKL berdasarkan SAW
        $topTempatPkl = SawResult::with(['alternative.tempatPkl'])
            ->orderBy('rank', 'asc')
            ->limit(5)
            ->get()
            ->map(function($result) {
                $tempat = $result->alternative->tempatPkl;
                
                return (object)[
                    'rank' => $result->rank,
                    'nama_perusahaan' => $tempat->nama_perusahaan,
                    'alamat_perusahaan' => $tempat->alamat_perusahaan,
                    'final_score' => $result->final_score,
                    'id' => $tempat->id,
                    // Method dari model TempatPKL
                    'getRataRataTotal' => function() use ($tempat) {
                        return $tempat->getRataRataTotal();
                    },
                    'getJumlahPenilai' => function() use ($tempat) {
                        return $tempat->getJumlahPenilai();
                    }
                ];
            });

        // Jika belum ada hasil SAW, gunakan data biasa (berdasarkan jumlah penilaian)
        if ($topTempatPkl->isEmpty()) {
            $topTempatPkl = TempatPKL::whereHas('penilaianMahasiswa')
                ->withCount('penilaianMahasiswa')
                ->orderByDesc('penilaian_mahasiswa_count')
                ->limit(5)
                ->get()
                ->map(function($tempat, $index) {
                    return (object)[
                        'rank' => $index + 1,
                        'nama_perusahaan' => $tempat->nama_perusahaan,
                        'alamat_perusahaan' => $tempat->alamat_perusahaan,
                        'final_score' => 0,
                        'id' => $tempat->id,
                        'getRataRataTotal' => function() use ($tempat) {
                            return $tempat->getRataRataTotal();
                        },
                        'getJumlahPenilai' => function() use ($tempat) {
                            return $tempat->getJumlahPenilai();
                        }
                    ];
                });
        }

        return view('mahasiswa.dashboard', compact('mahasiswa', 'topTempatPkl'));
    }
}