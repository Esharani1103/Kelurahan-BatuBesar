<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
     protected $primaryKey = 'id_rt';

    protected $fillable = [
        'id_rw',
        'nomor_rt'
    ];

    public function rw()
    {
        return $this->belongsTo(Rw::class,'id_rw');
    }

    public function keluargas()
    {
        return $this->hasMany(Keluarga::class,'id_rt');
    }
}