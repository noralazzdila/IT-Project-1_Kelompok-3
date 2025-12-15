<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPKL extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nilai_pkl';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tempatpkl_id',
        'nilai',
        'catatan',
        'pengajuan_pkl_id',
    ];

    /**
     * Get the pengajuan that owns the nilai.
     */
    public function pengajuan()
    {
        return $this->belongsTo(PengajuanPKL::class, 'pengajuan_pkl_id');
    }
}