<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Keluarga;

class Warga extends Model
{
    protected $fillable = [
        'keluarga_id',
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pendidikan',
        'jenis_pekerjaan',
        'status_perkawinan',
        'status_hubungan',
        'kewarganegaraan',
        'keterangan'
    ];

   public function keluarga()
    {
    return $this->belongsTo(Keluarga::class);
    }
}