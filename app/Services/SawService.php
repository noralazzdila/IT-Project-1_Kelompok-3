<?php

namespace App\Services;

use App\Models\Criteria;
use App\Models\Alternative;
use App\Models\SawResult;
use App\Models\TempatPKL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class SawService
{
    /**
     * Hitung ranking SAW langsung dari data TempatPKL.
     */
    public function calculateRanking(): array
    {
        $alternativesData = TempatPKL::all();
        $criteria = Criteria::where('weight', '>', 0)->get();

        if ($alternativesData->isEmpty() || $criteria->isEmpty()) {
            return [];
        }

        // 1. Kuantifikasi: Ubah data mentah (termasuk teks) menjadi matriks numerik
        $quantifiedMatrix = $this->quantifyAlternatives($alternativesData, $criteria);

        // 2. Normalisasi
        $normalizedMatrix = $this->normalizeMatrix($quantifiedMatrix, $criteria);

        // 3. Hitung skor
        $scores = $this->calculateFinalScores($normalizedMatrix, $criteria, $alternativesData);
        
        // 4. Buat Peringkat
        $rankedResults = $this->assignRanks($scores);

        // 5. Simpan Hasil
        $this->saveResults($rankedResults, $alternativesData);

        return $rankedResults;
    }

    /**
     * Mengubah koleksi TempatPKL menjadi matriks numerik berdasarkan kriteria.
     */
    private function quantifyAlternatives(Collection $alternativesData, Collection $criteria): array
    {
        $matrix = [];
        foreach ($alternativesData as $alt) {
            $row = ['id' => $alt->id];
            foreach ($criteria as $crit) {
                // Mencocokkan kode kriteria dengan kolom di tabel tempat_pkl
                $value = match ($crit->code) {
                    'C1' => $alt->jarak_lokasi,
                    'C2' => $this->quantifyValue($alt->fasilitas),
                    'C3' => $this->quantifyValue($alt->kesesuaian_program),
                    'C4' => $this->quantifyValue($alt->reputasi_perusahaan),
                    'C5' => $this->quantifyValue($alt->lingkungan_kerja),
                    default => 0,
                };
                $row[$crit->id] = (float) $value;
            }
            $matrix[] = $row;
        }
        return $matrix;
    }
    
    /**
     * Mengubah nilai teks menjadi angka.
     */
    private function quantifyValue(?string $textValue): int
    {
        if ($textValue === null) return 0;
        $lowerValue = strtolower($textValue);

        return match (true) {
            str_contains($lowerValue, 'sangat baik'), str_contains($lowerValue, 'lengkap'), str_contains($lowerValue, 'sesuai'), str_contains($lowerValue, 'profesional') => 5,
            str_contains($lowerValue, 'baik') => 4,
            str_contains($lowerValue, 'cukup'), str_contains($lowerValue, 'standar') => 3,
            str_contains($lowerValue, 'kurang') => 2,
            str_contains($lowerValue, 'sangat kurang'), str_contains($lowerValue, 'tidak') => 1,
            default => 0,
        };
    }

    /**
     * Menormalisasi matriks numerik.
     */
    private function normalizeMatrix(array $quantifiedMatrix, Collection $criteria): array
    {
        $normalizedMatrix = $quantifiedMatrix;

        foreach ($criteria as $crit) {
            $values = array_column($quantifiedMatrix, $crit->id);

            if (empty($values)) continue;

            if ($crit->type === 'benefit') {
                $maxValue = max($values);
                foreach ($quantifiedMatrix as $index => $row) {
                    $normalizedMatrix[$index][$crit->id] = $maxValue > 0 ? $row[$crit->id] / $maxValue : 0;
                }
            } else { // cost
                $minValue = min(array_filter($values)); // Ambil nilai minimum yang bukan nol
                foreach ($quantifiedMatrix as $index => $row) {
                    $normalizedMatrix[$index][$crit->id] = ($row[$crit->id] > 0 && $minValue > 0) ? $minValue / $row[$crit->id] : 0;
                }
            }
        }
        return $normalizedMatrix;
    }

    /**
     * Menghitung skor akhir dari matriks yang sudah dinormalisasi.
     */
    private function calculateFinalScores(array $normalizedMatrix, Collection $criteria, Collection $alternativesData): array
    {
        $scores = [];
        foreach ($normalizedMatrix as $row) {
            $score = 0;
            foreach ($criteria as $crit) {
                $score += $row[$crit->id] * $crit->weight;
            }
            $scores[] = [
                'tempat_pkl_id' => $row['id'],
                'final_score' => round($score, 6),
                'updated_at' => $alternativesData->find($row['id'])->updated_at,
            ];
        }
        return $scores;
    }

    /**
     * Memberi peringkat pada skor.
     */
    private function assignRanks(array $scores): array
    {
        usort($scores, function($a, $b) {
            if ($a['final_score'] < $b['final_score']) return 1;
            if ($a['final_score'] > $b['final_score']) return -1;
            return $b['updated_at'] <=> $a['updated_at'];
        });

        foreach ($scores as $index => &$score) {
            $score['rank'] = $index + 1;
        }
        return $scores;
    }

    /**
     * Menyimpan hasil ranking ke database.
     */
    private function saveResults(array $rankedResults, Collection $alternativesData): void
    {
        DB::transaction(function () use ($rankedResults, $alternativesData) {
            SawResult::query()->delete();
            Alternative::query()->delete();

            foreach ($rankedResults as $result) {
                $tempatPkl = $alternativesData->find($result['tempat_pkl_id']);
                if (!$tempatPkl) continue;

                $alternative = Alternative::create([
                    'code' => 'A' . $result['rank'],
                    'tempat_pkl_id' => $tempatPkl->id,
                ]);

                SawResult::create([
                    'alternative_id' => $alternative->id,
                    'final_score' => $result['final_score'],
                    'rank' => $result['rank'],
                    'calculated_at' => now(),
                ]);
            }
        });
    }

    /**
     * Dapatkan hasil ranking terbaru
     */
    public function getLatestRanking()
    {
        return SawResult::with(['alternative.tempatPkl'])
            ->orderBy('rank', 'asc')
            ->get();
    }
}