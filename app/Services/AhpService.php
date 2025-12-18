<?php

namespace App\Services;

use App\Models\Criteria;
use App\Models\AhpComparison;
use App\Models\Alternative;
use App\Models\AlternativeValue;
use App\Models\SawResult;
use App\Models\TempatPKL;
use Illuminate\Support\Facades\DB;

class AhpService
{
    /**
     * Menghitung bobot kriteria menggunakan AHP hanya untuk kriteria yang aktif.
     * Kriteria yang tidak aktif akan memiliki bobot 0.
     *
     * @param array $activeCriteriaIds
     * @return array
     */
    public function calculateWeights(array $activeCriteriaIds): array
    {
        // Reset bobot untuk kriteria yang tidak termasuk dalam perhitungan saat ini
        Criteria::whereNotIn('id', $activeCriteriaIds)->update(['weight' => 0]);

        // Ambil hanya kriteria yang aktif
        $activeCriteria = Criteria::whereIn('id', $activeCriteriaIds)->get();
        $n = $activeCriteria->count();

        if ($n < 2) {
            // Jika kurang dari 2, set bobotnya secara merata atau jadi 1 jika hanya ada 1
            if ($n === 1) {
                $criterion = $activeCriteria->first();
                $criterion->update(['weight' => 1]);
            }
            return [
                'weights' => $n === 1 ? [1] : [],
                'consistency_ratio' => 0,
                'is_consistent' => true,
                'lambda_max' => 0,
                'consistency_index' => 0
            ];
        }

        $matrix = $this->buildComparisonMatrix($activeCriteria);
        $normalizedMatrix = $this->normalizeMatrix($matrix, $n);
        $weights = $this->calculatePriorityVector($normalizedMatrix, $n);
        $consistency = $this->calculateConsistency($matrix, $weights, $n);

        // Update bobot ke database hanya untuk kriteria aktif
        foreach ($activeCriteria as $index => $criterion) {
            $criterion->update(['weight' => $weights[$index]]);
        }

        return [
            'weights' => $weights,
            'consistency_ratio' => $consistency['cr'],
            'is_consistent' => $consistency['cr'] < 0.1,
            'lambda_max' => $consistency['lambda_max'],
            'consistency_index' => $consistency['ci']
        ];
    }

    /**
     * Membangun matriks perbandingan dari koleksi kriteria yang aktif.
     *
     * @param \Illuminate\Database\Eloquent\Collection $activeCriteria
     * @return array
     */
    private function buildComparisonMatrix($activeCriteria): array
    {
        $n = $activeCriteria->count();
        $matrix = array_fill(0, $n, array_fill(0, $n, 1.0));
        $criteriaMap = $activeCriteria->pluck('id')->flip()->toArray();

        foreach ($activeCriteria as $i => $criterion1) {
            foreach ($activeCriteria as $j => $criterion2) {
                if ($i < $j) {
                    // Cari perbandingan dalam urutan apa pun
                    $comparison = AhpComparison::where(function ($query) use ($criterion1, $criterion2) {
                        $query->where('criteria_1_id', $criterion1->id)
                              ->where('criteria_2_id', $criterion2->id);
                    })->orWhere(function ($query) use ($criterion1, $criterion2) {
                        $query->where('criteria_1_id', $criterion2->id)
                              ->where('criteria_2_id', $criterion1->id);
                    })->first();

                    if ($comparison) {
                        // Jika urutan di database terbalik, maka nilainya adalah 1/value
                        $value = ($comparison->criteria_1_id == $criterion1->id) ? $comparison->value : 1 / $comparison->value;
                    } else {
                        $value = 1; // Default jika tidak ada perbandingan
                    }
                    
                    $matrix[$i][$j] = $value;
                    $matrix[$j][$i] = 1 / $value;
                }
            }
        }
        return $matrix;
    }

    private function normalizeMatrix(array $matrix, int $n): array
    {
        $normalized = array_fill(0, $n, array_fill(0, $n, 0));
        $columnSums = array_fill(0, $n, 0);

        for ($j = 0; $j < $n; $j++) {
            for ($i = 0; $i < $n; $i++) {
                $columnSums[$j] += $matrix[$i][$j];
            }
        }

        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $normalized[$i][$j] = $columnSums[$j] > 0 ? $matrix[$i][$j] / $columnSums[$j] : 0;
            }
        }

        return $normalized;
    }

    private function calculatePriorityVector(array $normalizedMatrix, int $n): array
    {
        $weights = [];
        for ($i = 0; $i < $n; $i++) {
            $weights[$i] = array_sum($normalizedMatrix[$i]) / $n;
        }
        return $weights;
    }

    /**
     * Menghitung rasio konsistensi.
     *
     * @param array $matrix
     * @param array $weights
     * @param int $n
     * @return array
     */
    private function calculateConsistency(array $matrix, array $weights, int $n): array
    {
        // Indeks Rasio Konsistensi Acak (RI)
        $ri = [0, 0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45, 1.49, 1.51, 1.48, 1.56, 1.57, 1.59];

        if ($n <= 1) {
            return ['lambda_max' => 1, 'ci' => 0, 'cr' => 0];
        }

        $weightedSumVector = array_fill(0, $n, 0);
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $weightedSumVector[$i] += $matrix[$i][$j] * $weights[$j];
            }
        }

        $lambdaMax = 0;
        for ($i = 0; $i < $n; $i++) {
            if ($weights[$i] > 0) {
                $lambdaMax += $weightedSumVector[$i] / $weights[$i];
            }
        }
        $lambdaMax /= $n;

        $ci = ($n > 1) ? ($lambdaMax - $n) / ($n - 1) : 0;
        
        // Gunakan RI yang sesuai atau RI terbesar jika n > 15
        $randomIndex = $n <= 15 ? $ri[$n-1] : 1.59;
        $cr = ($randomIndex > 0) ? $ci / $randomIndex : 0;

        return [
            'lambda_max' => $lambdaMax,
            'ci' => $ci,
            'cr' => $cr,
        ];
    }

    public function saveComparison(int $criteria1Id, int $criteria2Id, float $value): void
    {
        AhpComparison::updateOrCreate(
            [
                'criteria_1_id' => $criteria1Id,
                'criteria_2_id' => $criteria2Id
            ],
            ['value' => $value]
        );
    }
}