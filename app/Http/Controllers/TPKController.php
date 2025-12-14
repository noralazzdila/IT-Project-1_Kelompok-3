<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TPKController extends Controller
{
    public function hitung()
    {
        // --- LOAD EXCEL ---
        $file = public_path("Data.xlsx");
        $spreadsheet = IOFactory::load($file);

        // === SHEET 1: DATA ALTERNATIF ===
        $sheet1 = $spreadsheet->getSheet(0)->toArray();
        $sheet1 = array_slice($sheet1, 1); // hapus header

        $nama = [];
        $alamat = [];
        $dataAlternatif = [];

        foreach ($sheet1 as $row) {
            $nama[]   = $row[0];
            $alamat[] = $row[1];

            // Jarak bisa memiliki format "3,7"
            $row[2] = floatval(str_replace(",", ".", $row[2]));

            // Ambil mulai kolom Jarak → akhir kriteria
            $dataAlternatif[] = array_slice($row, 2);
        }

        // === SHEET 2: PAIRWISE AHP ===
        $sheet2 = $spreadsheet->getSheet(1)->toArray();
        $sheet2 = array_slice($sheet2, 1); // hapus header baris
        $pairwise = [];

        foreach ($sheet2 as $row) {
            $pairwise[] = array_slice($row, 1); // hilangkan kolom teks
        }

        $n = count($pairwise);

        // --- NORMALISASI AHP ---
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

        // --- BOBOT KRITERIA ---
        $weights = [];
        for ($i = 0; $i < $n; $i++) {
            $weights[$i] = array_sum($normalized[$i]) / $n;
        }

        // === SAW NORMALIZATION ===
        $norm = [];
        $kolom = count($dataAlternatif[0]);

        for ($j = 0; $j < $kolom; $j++) {
            $colValues = array_column($dataAlternatif, $j);

            if ($j == 0) {
                // COST → Jarak
                $min = min($colValues);
                foreach ($colValues as $i => $v) {
                    $norm[$i][$j] = $min / $v;
                }
            } else {
                // BENEFIT
                $max = max($colValues);
                foreach ($colValues as $i => $v) {
                    $norm[$i][$j] = $v / $max;
                }
            }
        }

        // === HITUNG SKOR SAW ===
        $scores = [];

        foreach ($norm as $i => $row) {
            $score = 0;
            foreach ($row as $j => $value) {
                $score += $value * $weights[$j];
            }
            $scores[$i] = $score;
        }

        // === GABUNGKAN HASIL ===
        $hasil = [];
        foreach ($scores as $i => $score) {
            $hasil[] = [
                "nama" => $nama[$i],
                "alamat" => $alamat[$i],
                "skor" => $score,
            ];
        }

        // SORT DESC
        usort($hasil, fn($a, $b) => $b['skor'] <=> $a['skor']);

        return view('mahasiswa.ranking', compact('hasil'));
    }
}
