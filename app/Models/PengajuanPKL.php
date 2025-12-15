<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PengajuanPKL extends Model
{
    use HasFactory;

    // Nama tabel (optional, default plural dari nama model)
    protected $table = 'pengajuan_pkl';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'mahasiswa_id',
        'pdf_path',
        'status', // uploaded, diproses, diterima, ditolak
        'nama_perusahaan',
        'bidang',
        'alamat',
        'nama_pic',
        'telepon_pic',
        'tempat_pkl_id',
    ];

    public function mahasiswa()
{
    return $this->belongsTo(User::class, 'mahasiswa_id');
}
    /**
     * Ambil pengajuan mahasiswa saat ini
     */
    public static function pengajuanSaatIni()
    {
        return self::where('mahasiswa_id', Auth::id())->first();
    }

    public function nilaiPKL()
{
    return $this->hasOne(NilaiPKL::class, 'pengajuan_pkl_id');
}

}
