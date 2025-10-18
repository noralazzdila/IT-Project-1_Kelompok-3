<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa'; 

    protected $fillable = [
    'nim', 'nama', 'jurusan', 'angkatan'
];


    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'mahasiswa_id');
    }

    
}
