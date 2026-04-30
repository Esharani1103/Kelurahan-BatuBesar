<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rw extends Model
{
    protected $primaryKey = 'id_rw';

    protected $fillable = [
        'nomor_rw'
    ];

    public function rts()
    {
        return $this->hasMany(Rt::class,'id_rw');
    }
}