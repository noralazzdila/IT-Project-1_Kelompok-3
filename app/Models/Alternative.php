<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    protected $fillable = ['code', 'tempat_pkl_id'];

    public function tempatPkl()
    {
        return $this->belongsTo(TempatPKL::class);
    }

    public function values()
    {
        return $this->hasMany(AlternativeValue::class);
    }

    public function sawResult()
    {
        return $this->hasOne(SawResult::class);
    }
}
