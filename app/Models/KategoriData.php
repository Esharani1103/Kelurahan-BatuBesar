<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriData extends Model
{
    protected $table = 'kategori_data';

    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori'
    ];
}