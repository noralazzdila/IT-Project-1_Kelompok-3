<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemberkasan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     * Sesuaikan jika nama tabel Anda bukan 'pemberkasans'.
     * @var string
     */
    protected $table = 'pemberkasans'; // Ganti jika nama tabel Anda berbeda

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Tambahkan kolom-kolom lain sesuai dengan skema tabel Anda.
     * @var array<int, string>
     */
    protected $fillable = [
        'mahasiswa_id',
        'form_bimbingan_path', // Path ke file Form Bimbingan
        'sertifikat_path',     // Path ke file Sertifikat PKL
        'laporan_final_path',  // Path ke file Laporan Final
        'is_lengkap',          // Kolom boolean untuk status kelengkapan
        'tanggal_verifikasi',
        // Tambahkan kolom lain di sini
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     * @var array
     */
    protected $casts = [
        'is_lengkap' => 'boolean',
        'tanggal_verifikasi' => 'datetime',
    ];

    /**
     * Mendefinisikan relasi Many-to-One dengan Mahasiswa.
     * Setiap Pemberkasan dimiliki oleh satu Mahasiswa.
     */
    public function mahasiswa()
    {
        // Asumsi: foreign key di tabel 'pemberkasans' adalah 'mahasiswa_id'
        // dan merujuk ke 'id' di tabel 'mahasiswas'
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

}