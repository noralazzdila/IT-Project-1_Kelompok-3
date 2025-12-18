<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SawResult extends Model
{
    protected $fillable = [
        'alternative_id',
        'final_score',
        'rank',
        'calculated_at'
    ];

    protected $casts = [
        'calculated_at' => 'datetime',
    ];

    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }
}
