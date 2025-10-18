<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';

    protected $fillable = [
        'nama_status',
        'status',
        'keterangan',
        'tgl_update',
    ];

    public $timestamps = false; // karena kita tidak pakai created_at & updated_at

    protected $casts = [
        'tgl_update' => 'datetime',
    ];
}
