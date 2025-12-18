<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SawService;

class CalculateTpkRanking extends Command
{
    protected $signature = 'tpk:calculate';
    protected $description = 'Hitung ranking TPK tempat PKL';

    public function handle()
    {
        $this->info('🔄 Memulai perhitungan ranking TPK...');
        $this->newLine();

        try {
            $sawService = app(SawService::class);
            
            $this->info('📊 Step 1: Agregasi data penilaian mahasiswa...');
            $sawService->agregateData();
            $this->info('✅ Agregasi selesai!');
            $this->newLine();
            
            $this->info('🧮 Step 2: Normalisasi nilai...');
            $this->info('📈 Step 3: Menghitung skor SAW...');
            $this->info('🏆 Step 4: Menentukan ranking...');
            
            $results = $sawService->calculateRanking();
            
            $this->newLine();
            $this->info('✅ Perhitungan selesai!');
            $this->newLine();
            
            $this->table(
                ['Rank', 'Alternative ID', 'Skor'],
                collect($results)->map(fn($r) => [
                    $r['rank'],
                    $r['alternative_id'],
                    number_format($r['final_score'], 4)
                ])->toArray()
            );
            
            $this->newLine();
            $this->info('🎉 Ranking TPK berhasil dihitung!');
            $this->info('📍 Cek hasil di dashboard mahasiswa');
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}

/**
 * CARA MENJALANKAN:
 * php artisan tpk:calculate
 */