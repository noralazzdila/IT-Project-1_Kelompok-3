<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\TempatPKL;
use App\Models\PenilaianTempatPkl;

class PenilaianTempatPKLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Memulai seeder Penilaian Tempat PKL...');

        // Hapus data penilaian lama untuk menghindari duplikasi
        PenilaianTempatPkl::truncate();

        // 1. Ambil data master yang diperlukan
        $tempatPkls = TempatPKL::all();
        $mahasiswas = User::where('role', 'mahasiswa')->get();

        // 2. Validasi apakah data master ada
        if ($tempatPkls->count() < 2) {
            $this->command->error('❌ Seeder dibatalkan: Diperlukan minimal 2 data Tempat PKL di database.');
            return;
        }
        if ($mahasiswas->count() < 5) {
            $this->command->error('❌ Seeder dibatalkan: Diperlukan minimal 5 data mahasiswa di database.');
            return;
        }
        
        $this->command->info("Menggunakan {$tempatPkls->count()} tempat PKL dan {$mahasiswas->count()} mahasiswa untuk membuat data dummy.");

        $penilaian = [];

        // 3. Buat 25 penilaian dummy
        for ($i = 0; $i < 25; $i++) {
            $mahasiswa = $mahasiswas->random();
            $tempat = $tempatPkls->random();

            // Cek untuk menghindari duplikasi penilaian oleh mahasiswa yang sama untuk tempat yang sama
            $uniqueKey = $mahasiswa->id . '-' . $tempat->id;
            if (isset($penilaian[$uniqueKey])) {
                continue; // Lewati jika kombinasi sudah ada
            }

            $penilaian[$uniqueKey] = [
                'mahasiswa_id'      => $mahasiswa->id,
                'tempat_pkl_id'   => $tempat->id,
                'nama_tempat'       => $tempat->nama_perusahaan, // Ambil dari data master
                'alamat'            => $tempat->alamat_perusahaan, // Ambil dari data master
                'jarak'             => rand(1, 25), // Jarak acak dari 1km - 25km
                'fasilitas'         => rand(2, 5),  // Nilai acak 2-5
                'program_magang'    => rand(2, 5),
                'reputasi'          => rand(3, 5),
                'kondisi_lingkungan'=> rand(2, 5),
                'komentar'          => 'Penilaian dummy oleh ' . $mahasiswa->name,
                'created_at'        => now(),
                'updated_at'        => now(),
            ];
        }

        // 4. Masukkan data ke database
        PenilaianTempatPkl::insert(array_values($penilaian));

        $this->command->info('✅ Seeder Penilaian Tempat PKL berhasil dijalankan. ' . count($penilaian) . ' data dummy dibuat.');
    }
}