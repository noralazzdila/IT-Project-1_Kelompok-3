<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa'; 

    protected $fillable = [
    'nim', 'nama', 'jurusan', 'angkatan', 'user_id'
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
