<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengumumanTicker extends Model
{
    use HasFactory;

    protected $table    = 'pengumuman_ticker';
    protected $fillable = ['teks','ikon','urutan','aktif'];
    protected $casts    = ['aktif' => 'boolean', 'urutan' => 'integer'];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
