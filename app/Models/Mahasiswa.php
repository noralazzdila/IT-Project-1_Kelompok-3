<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa'; 

    protected $fillable = [
        'nim',
        'nama',
        'user_id',
        'jenis_kelamin',
        'tanggal_lahir',
        'prodi',
        'kelas',
        'tahun_angkatan',
        'dosen_pembimbing',
        'tempat_pkl',
        'status_pkl',
        'no_hp',
        'email',
    ];


    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'mahasiswa_id');
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}


    
}
