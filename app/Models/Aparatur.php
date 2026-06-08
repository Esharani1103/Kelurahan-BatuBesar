<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aparatur extends Model
{
    use HasFactory;

    protected $table    = 'aparatur';
    protected $fillable = ['nama','jabatan','nip','foto','urutan','aktif'];
    protected $casts    = ['aktif' => 'boolean'];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }

    public function getInisialAttribute(): string
    {
        $kata = explode(' ', trim($this->nama));
        if (count($kata) >= 2) {
            return strtoupper(substr($kata[0], 0, 1) . substr($kata[1], 0, 1));
        }
        return strtoupper(substr($this->nama, 0, 2));
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}
