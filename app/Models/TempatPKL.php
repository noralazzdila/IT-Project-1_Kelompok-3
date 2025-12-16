<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NilaiPKL;

class TempatPKL extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tempat_pkl';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mahasiswa_id',
        'nama_perusahaan',
        'alamat_perusahaan',
        'jarak_lokasi',
        'reputasi_perusahaan',
        'fasilitas',
        'kesesuaian_program',
        'lingkungan_kerja',
        'pdf_transkrip',
        'status',
    ];
    public function mahasiswa() {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function nilaiPKL() {
    return $this->hasOne(NilaiPKL::class);
}
}