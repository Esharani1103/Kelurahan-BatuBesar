<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SyaratDokumen extends Model
{
    use HasFactory;

    protected $table    = 'syarat_dokumen';
    protected $fillable = ['judul','ikon','urutan','aktif'];
    protected $casts    = ['aktif' => 'boolean', 'urutan' => 'integer'];

    public function items()
    {
        return $this->hasMany(SyaratDokumenItem::class)->orderBy('urutan');
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
