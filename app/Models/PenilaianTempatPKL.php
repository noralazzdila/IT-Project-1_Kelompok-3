<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianTempatPkl extends Model
{
    use HasFactory;

    protected $table = 'penilaian_tempat_pkl';

    protected $fillable = [
        'mahasiswa_id',
        'tempat_pkl_id',
        'nama_tempat',
        'alamat',
        'jarak',
        'fasilitas',
        'program_magang',
        'reputasi',
        'kondisi_lingkungan',
        'komentar',
    ];

    protected $casts = [
        'jarak' => 'decimal:2',
    ];

    /**
     * Relasi ke mahasiswa/user
     */
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    /**
     * Relasi ke tempat PKL
     */
    public function tempatPkl()
    {
        return $this->belongsTo(TempatPKL::class, 'tempat_pkl_id');
    }

    /**
     * Hitung rata-rata semua aspek penilaian
     */
    public function getRataTotalAttribute()
    {
        return ($this->fasilitas + $this->program_magang + $this->reputasi + $this->kondisi_lingkungan) / 4;
    }

    /**
     * Scope untuk mendapatkan penilaian berdasarkan tempat PKL
     */
    public function scopeByTempatPkl($query, $tempatPklId)
    {
        return $query->where('tempat_pkl_id', $tempatPklId);
    }
}