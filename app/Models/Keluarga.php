<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Rt;
use App\Models\Warga;

class Keluarga extends Model
{
    protected $fillable = [
        'id_rt',
        'no_kk',
        'nama_kepala_keluarga',
        'alamat'
    ];

    public function rt()
    {
        return $this->belongsTo(Rt::class, 'id_rt');
    }

    public function wargas()
    {
        return $this->hasMany(Warga::class, 'keluarga_id');
    }
}