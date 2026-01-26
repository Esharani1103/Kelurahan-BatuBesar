<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    protected $fillable = [
        'jumlah_penduduk',
        'jumlah_kk',
        'no_kk',
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'umur',
        'agama',
        'pendidikan',
        'jenis_pekerjaan',
        'alamat_lengkap',
        'rt',
        'rw',
        'status_perkawinan',
        'status_hubungan',
        'nama_kepala_keluarga',
        'kewarganegaraan',
        'keterangan'
    ];
}
