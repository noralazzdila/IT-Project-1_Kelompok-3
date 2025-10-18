<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPengantar extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'surat_pengantar';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'prodi',
        'tempat_pkl',
        'alamat_perusahaan',
        'tanggal_pengajuan',
        'status',
        'file_surat',
        'catatan',
    ];
}
