<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TPKController extends Controller
{
    public function hitung()
    {
        /* =====================================================
         * 1. LOAD EXCEL
         * ===================================================== */
        $file = public_path('Data.xlsx');
        $spreadsheet = IOFactory::load($file);

        /* =====================================================
         * 2. SHEET 1 – DATA ALTERNATIF
         * Struktur Excel:
         * A = Nama
         * B = Jarak (KM)  -> COST
         * C = Fasilitas  -> BENEFIT
         * D = Program Magang -> BENEFIT
         * E = Reputasi -> BENEFIT
         * F = Lingkungan -> BENEFIT
         * ===================================================== */
        $sheet1 = $spreadsheet->getSheet(0)->toArray();
        $sheet1 = array_slice($sheet1, 1); // hapus header

        $nama = [];
        $dataAlternatif = [];

        foreach ($sheet1 as $row) {
            $nama[] = $row[0];

            $dataAlternatif[] = [
                floatval(str_replace(',', '.', $row[1])), // Jarak (COST)
                floatval($row[2]), // Fasilitas
                floatval($row[3]), // Program Magang
                floatval($row[4]), // Reputasi
                floatval($row[5]), // Lingkungan
            ];
        }

        /* =====================================================
         * 3. SHEET 2 – PAIRWISE MATRIX (AHP)
         * ===================================================== */
        $sheet2 = $spreadsheet->getSheet(1)->toArray();
        $sheet2 = array_slice($sheet2, 1); // hapus header

        $pairwise = [];
        foreach ($sheet2 as $row) {
            $cleanRow = [];
            foreach (array_slice($row, 1) as $val) {
                $cleanRow[] = floatval(str_replace(',', '.', $val));
            }
            $pairwise[] = $cleanRow;
        }

        $n = count($pairwise);

        /* =====================================================
         * 4. NORMALISASI AHP
         * ===================================================== */
        $columnSum = array_fill(0, $n, 0);
        for ($j = 0; $j < $n; $j++) {
            for ($i = 0; $i < $n; $i++) {
                $columnSum[$j] += $pairwise[$i][$j];
            }
        }

        $normalized = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normalized[$i][$j] = $pairwise[$i][$j] / $columnSum[$j];
            }
        }

        /* =====================================================
         * 5. BOBOT KRITERIA (AHP)
         * ===================================================== */
        $weights = [];
        for ($i = 0; $i < $n; $i++) {
            $weights[$i] = round(array_sum($normalized[$i]) / $n, 6);
        }

        // VALIDASI JUMLAH KRITERIA
        if (count($weights) !== count($dataAlternatif[0])) {
            dd('Jumlah bobot AHP dan kriteria SAW tidak sama');
        }

        /* =====================================================
         * 6. NORMALISASI SAW
         * ===================================================== */
        $tipeKriteria = [
            'cost',    // Jarak
            'benefit', // Fasilitas
            'benefit', // Program Magang
            'benefit', // Reputasi
            'benefit', // Lingkungan
        ];

        $norm = [];
        $kolom = count($dataAlternatif[0]);

        for ($j = 0; $j < $kolom; $j++) {
            $colValues = array_column($dataAlternatif, $j);

            if ($tipeKriteria[$j] === 'cost') {
                $min = min($colValues);

                foreach ($colValues as $i => $v) {
                    if ($v == 0 || $min == 0) {
                        $norm[$i][$j] = 0;
                    } else {
                        $norm[$i][$j] = $min / $v;
                    }
                }

            } else { // BENEFIT
                $max = max($colValues);

                foreach ($colValues as $i => $v) {
                    if ($max == 0) {
                        $norm[$i][$j] = 0;
                    } else {
                        $norm[$i][$j] = $v / $max;
                    }
                }
            }
        }

        /* =====================================================
         * 7. HITUNG SKOR SAW
         * ===================================================== */
        $scores = [];
        foreach ($norm as $i => $row) {
            $score = 0;
            foreach ($row as $j => $value) {
                $score += $value * $weights[$j];
            }
            $scores[$i] = round($score, 4);
        }

        /* =====================================================
         * 8. GABUNG & SORT HASIL
         * ===================================================== */
        $hasil = [];
        foreach ($scores as $i => $score) {
            $hasil[] = [
                'nama' => $nama[$i],
                'skor' => $score,
            ];
        }

        usort($hasil, fn($a, $b) => $b['skor'] <=> $a['skor']);

        return view('mahasiswa.ranking', compact('hasil'));
    }
}
