<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = [
        'nama',
        'anonim',
        'kategori',
        'pesan',
        'foto',
        'status',
    ];
}
