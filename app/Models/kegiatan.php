<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

 
class Kegiatan extends Model
{
    use HasFactory;
 
    protected $table = 'kegiatans';
 
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'tanggal',
        'urutan',
        'aktif',
    ];
 
    protected $casts = [
        'aktif'   => 'boolean',
        'urutan'  => 'integer',
        'tanggal' => 'date',
    ];
 
    // Scope: hanya yang aktif, untuk carousel beranda
    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
 
    // Scope: semua kegiatan, terbaru dulu — untuk halaman dokumentasi
    public function scopeTerbaru($query)
    {
        return $query->orderByDesc('tanggal');
    }
 
    // Accessor: URL gambar lengkap
    public function getGambarUrlAttribute(): ?string
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }
 
    // Accessor: tanggal format Indonesia, contoh "12 Juni 2026"
    public function getTanggalIndoAttribute(): string
    {
        return $this->tanggal->translatedFormat('d F Y');
    }
}
 