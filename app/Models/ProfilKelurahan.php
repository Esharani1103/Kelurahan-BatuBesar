<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilKelurahan extends Model
{
    protected $fillable = [
        'gambaran_judul',
        'gambaran_isi',
        'visi',
        'misi',
        'selayang_judul',
        'selayang_isi',
        'struktur_nama',
        'struktur_jabatan',
        'struktur_nip',
        'struktur_foto',
    ];

    protected $casts = [
        'misi' => 'array',
    ];
}