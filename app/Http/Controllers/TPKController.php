<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;

class TPKController extends Controller
{
    public function hitung()
    {
        /* =======================
         * LOAD EXCEL
         * ======================= */
        $spreadsheet = IOFactory::load(public_path('Data.xlsx'));

        /* =======================
         * DATA ALTERNATIF
         * ======================= */
        $sheet1 = array_slice($spreadsheet->getSheet(0)->toArray(), 1);

        $nama = [];
        $dataAlternatif = [];

        foreach ($sheet1 as $row) {
            $nama[] = $row[0];
            $dataAlternatif[] = [
                floatval(str_replace(',', '.', $row[1])), // Jarak
                floatval($row[2]), // Fasilitas
                floatval($row[3]), // Program Magang
                floatval($row[4]), // Reputasi
                floatval($row[5]), // Lingkungan
            ];
        }

        /* =======================
         * PAIRWISE AHP
         * ======================= */
        $sheet2 = array_slice($spreadsheet->getSheet(1)->toArray(), 1);

        $pairwise = [];
        foreach ($sheet2 as $row) {
            $pairwise[] = array_map(
                fn($v) => floatval(str_replace(',', '.', $v)),
                array_slice($row, 1)
            );
        }

        $n = count($pairwise);

        /* =======================
         * NORMALISASI AHP
         * ======================= */
        $colSum = array_fill(0, $n, 0);
        for ($j = 0; $j < $n; $j++) {
            for ($i = 0; $i < $n; $i++) {
                $colSum[$j] += $pairwise[$i][$j];
            }
        }

        $normAHP = [];
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normAHP[$i][$j] = $pairwise[$i][$j] / $colSum[$j];
            }
        }

 
        /* =======================
        * 5. BOBOT AHP (EIGENVECTOR – SAMA PYTHON)
        * ======================= */
        $weights = array_fill(0, $n, 1 / $n); // vektor awal
        $maxIter = 100;
        $epsilon = 1e-9;

        for ($iter = 0; $iter < $maxIter; $iter++) {
            $newWeights = array_fill(0, $n, 0);

            // perkalian matriks pairwise × vektor bobot
            for ($i = 0; $i < $n; $i++) {
                for ($j = 0; $j < $n; $j++) {
                    $newWeights[$i] += $pairwise[$i][$j] * $weights[$j];
                }
            }

            // normalisasi
            $sum = array_sum($newWeights);
            for ($i = 0; $i < $n; $i++) {
                $newWeights[$i] /= $sum;
            }

            // cek konvergensi
            $diff = 0;
            for ($i = 0; $i < $n; $i++) {
                $diff += abs($newWeights[$i] - $weights[$i]);
            }

            $weights = $newWeights;

            if ($diff < $epsilon) {
                break;
            }
        }


        /* =======================
         * NORMALISASI SAW (PYTHON STYLE)
         * ======================= */
        $tipe = ['cost', 'benefit', 'benefit', 'benefit', 'benefit'];
        $epsilon = 0.0000001; // angka kecil pengganti nol
        $normSAW = [];

        for ($j = 0; $j < count($dataAlternatif[0]); $j++) {
            $col = array_column($dataAlternatif, $j);

            if ($tipe[$j] === 'cost') {
                $min = min($col);

                foreach ($col as $i => $v) {
                    $v = ($v == 0) ? $epsilon : $v;   // 🔥 FIX DIVISION BY ZERO
                    $normSAW[$i][$j] = $min / $v;
                }

            } else { // BENEFIT
                $max = max($col);

                foreach ($col as $i => $v) {
                    $normSAW[$i][$j] = $v / $max;
                }
            }
        }
        /* =======================
         * SKOR AKHIR SAW
         * ======================= */
        $hasil = [];
        foreach ($normSAW as $i => $row) {
            $score = 0;
            foreach ($row as $j => $val) {
                $score += $val * $weights[$j];
            }
            $hasil[] = [
                'nama' => $nama[$i],
                'skor' => round($score, 4),
            ];
        }

        usort($hasil, fn($a, $b) => $b['skor'] <=> $a['skor']);

        return view('mahasiswa.ranking', compact('hasil'));
    }
}
