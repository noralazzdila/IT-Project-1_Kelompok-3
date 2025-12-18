<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AhpService;
use App\Services\SawService;
use App\Models\Criteria;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SpkController extends Controller
{
    protected $ahpService;
    protected $sawService;

    public function __construct(AhpService $ahpService, SawService $sawService)
    {
        $this->ahpService = $ahpService;
        $this->sawService = $sawService;
    }

    /**
     * Menyimpan perbandingan AHP dan menghitung bobot.
     */
    public function saveAhpComparisonsAndCalculate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comparisons' => 'required|array',
            'comparisons.*.criteria_1_id' => 'required|integer|exists:criteria,id',
            'comparisons.*.criteria_2_id' => 'required|integer|exists:criteria,id',
            'comparisons.*.value' => 'required|numeric',
            'active_criteria_ids' => 'required|array',
            'active_criteria_ids.*' => 'integer|exists:criteria,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Data perbandingan tidak valid.', 'errors' => $validator->errors()], 400);
        }

        try {
            // Simpan nilai perbandingan
            foreach ($request->input('comparisons') as $comparison) {
                $this->ahpService->saveComparison(
                    $comparison['criteria_1_id'],
                    $comparison['criteria_2_id'],
                    floatval($comparison['value'])
                );
            }
            
            // Hitung bobot hanya untuk kriteria aktif
            $result = $this->ahpService->calculateWeights($request->input('active_criteria_ids'));

            $data = [
                // Ambil semua kriteria untuk ditampilkan di tabel hasil
                'criteria_all' => Criteria::orderBy('code', 'asc')->get(), 
                'consistency' => $result,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Bobot kriteria berhasil dihitung.',
                'data' => $data
            ]);

        } catch (\Exception $e) {
            Log::error('Error in AHP Calculation: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan pada server saat menghitung AHP: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Menjalankan perhitungan SAW untuk mendapatkan ranking.
     */
    public function calculateSaw()
    {
        try {
            // Pastikan bobot sudah ada dan tidak nol semua
            if (Criteria::sum('weight') == 0) {
                 return response()->json(['success' => false, 'message' => 'Bobot kriteria masih nol. Harap hitung bobot AHP terlebih dahulu.'], 400);
            }

            $this->sawService->calculateRanking();
            $results = $this->sawService->getLatestRanking();

            $formattedResults = $results->map(function ($item) {
                return [
                    'rank' => $item->rank,
                    'nama_tempat' => $item->alternative->tempatPkl->nama_perusahaan,
                    'alamat' => $item->alternative->tempatPkl->alamat_perusahaan,
                    'score' => $item->final_score,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Perankingan SAW berhasil dihitung.',
                'data' => $formattedResults,
            ]);

        } catch (\Exception $e) {
            Log::error('Error in SAW Calculation: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan pada server saat menghitung SAW.'], 500);
        }
    }

    /**
     * Mengambil bobot kriteria yang tersimpan saat ini.
     */
    public function getCriteriaWeights()
    {
        try {
            $criteria = Criteria::orderBy('code', 'asc')->get();
            return response()->json(['success' => true, 'criteria' => $criteria]);
        } catch (\Exception $e) {
            Log::error('Error fetching criteria weights: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal memuat bobot kriteria.'], 500);
        }
    }
}
