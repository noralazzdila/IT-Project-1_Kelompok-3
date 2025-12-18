<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AhpComparison extends Model
{
    protected $fillable = ['criteria_1_id', 'criteria_2_id', 'value'];

    public function criteria1()
    {
        return $this->belongsTo(Criteria::class, 'criteria_1_id');
    }

    public function criteria2()
    {
        return $this->belongsTo(Criteria::class, 'criteria_2_id');
    }
}
