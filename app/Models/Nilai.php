<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // 👈 Tambahkan ini

class Nilai extends Model
{
    protected $table = 'nilai';

    protected $fillable = [
        'mahasiswa_id',
        'ipk',
        'count_a',
        'count_b_plus',
        'count_b',
        'count_c_plus',
        'count_c',
        'count_d',
        'sks_d', // 👈 Tambahkan kolom baru
        'count_e',
        'total_sks',
        'sheet_name',
        'pdf_path'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Accessor untuk menentukan status kelayakan secara otomatis.
     */
    public function getStatusAttribute(): string
    {
        $ipkOk = $this->ipk >= 2.5;
        $sksDOk = $this->sks_d <= 6;
        $nilaiEOk = $this->count_e == 0;

        if ($ipkOk && $sksDOk && $nilaiEOk) {
            return 'Memenuhi Syarat';
        }

        return 'Belum Memenuhi Syarat';
    }

    /**
     * Accessor untuk memberikan warna pada status.
     */
    public function getStatusColorAttribute(): string
    {
        if ($this->getStatusAttribute() === 'Memenuhi Syarat') {
            return 'success'; // Warna hijau untuk bootstrap
        }

        return 'danger'; // Warna merah untuk bootstrap
    }
}