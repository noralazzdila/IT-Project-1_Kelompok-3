<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_mahasiswa', // Baru
        'nim',            // Baru
        'nama_pembimbing',// Baru
        'nama_penguji',   // Baru
        'judul',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'ruang',
    ];

    
}