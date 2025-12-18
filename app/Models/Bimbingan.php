<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bimbingan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'mahasiswa_nama',
        'nim',
        'dosen_pembimbing',
        'tanggal_bimbingan',
        'topik_bimbingan',
        'catatan',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_bimbingan' => 'date',
    ];

    /**
     * Get the Dosen (lecturer) associated with the bimbingan.
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing');
    }
}

