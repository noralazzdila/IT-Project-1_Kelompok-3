<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Criteria;


class CriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criteria = [
            [
                'code' => 'C1',
                'name' => 'Jarak',
                'type' => 'cost', // Semakin dekat semakin baik
                'weight' => 0
            ],
            [
                'code' => 'C2',
                'name' => 'Fasilitas',
                'type' => 'benefit',
                'weight' => 0
            ],
            [
                'code' => 'C3',
                'name' => 'Program Magang',
                'type' => 'benefit',
                'weight' => 0
            ],
            [
                'code' => 'C4',
                'name' => 'Reputasi Perusahaan',
                'type' => 'benefit',
                'weight' => 0
            ],
            [
                'code' => 'C5',
                'name' => 'Kondisi Lingkungan',
                'type' => 'benefit',
                'weight' => 0
            ]
        ];

        foreach ($criteria as $c) {
            Criteria::create($c);
        }

        $this->command->info('✅ 5 Kriteria berhasil dibuat!');
    }
}
