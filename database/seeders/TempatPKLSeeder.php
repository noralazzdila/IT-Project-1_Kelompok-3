<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TempatPKL;
use Illuminate\Support\Facades\Schema;

class TempatPKLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Menjalankan TempatPKLSeeder...');
        
        Schema::disableForeignKeyConstraints();
        TempatPKL::truncate();
        Schema::enableForeignKeyConstraints();

        $tempatPkls = [
            [
                'nama_perusahaan' => 'PT Telkom Indonesia (Witel Kalsel)',
                'alamat_perusahaan' => 'Jl. A. Yani No.KM. 4.5, Karang Mekar, Kec. Banjarmasin Tim., Kota Banjarmasin',
                'jarak_lokasi' => 5.5,
                'reputasi_perusahaan' => 'Sangat Baik',
                'fasilitas' => 'Lengkap',
                'kesesuaian_program' => 'Sesuai',
                'lingkungan_kerja' => 'Profesional',
                'pdf_transkrip' => 'dummy.pdf', // Nilai dummy
                'status' => 'Disetujui',
            ],
            [
                'nama_perusahaan' => 'Dinas Komunikasi dan Informatika Provinsi Kalimantan Selatan',
                'alamat_perusahaan' => 'Jl. Dharma Praja II, Trikora, Kec. Banjarbaru, Kota Banjarbaru',
                'jarak_lokasi' => 25.0,
                'reputasi_perusahaan' => 'Baik',
                'fasilitas' => 'Cukup',
                'kesesuaian_program' => 'Sesuai',
                'lingkungan_kerja' => 'Formal',
                'pdf_transkrip' => 'dummy.pdf',
                'status' => 'Disetujui',
            ],
            [
                'nama_perusahaan' => 'Bank Kalsel Kantor Pusat',
                'alamat_perusahaan' => 'Jl. Lambung Mangkurat No.1, Kertak Baru Ulu, Kec. Banjarmasin Tengah, Kota Banjarmasin',
                'jarak_lokasi' => 2.1,
                'reputasi_perusahaan' => 'Sangat Baik',
                'fasilitas' => 'Lengkap',
                'kesesuaian_program' => 'Sesuai',
                'lingkungan_kerja' => 'Formal',
                'pdf_transkrip' => 'dummy.pdf',
                'status' => 'Disetujui',
            ],
        ];

        foreach ($tempatPkls as $tempat) {
            TempatPKL::create($tempat);
        }
        
        $this->command->info('✅ ' . count($tempatPkls) . ' data tempat PKL berhasil ditambahkan.');
    }
}
