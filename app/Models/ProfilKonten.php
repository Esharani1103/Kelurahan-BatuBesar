<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class ProfilKonten extends Model
{
    use HasFactory;
 
    protected $table = 'profil_konten';
 
    protected $fillable = [
        'slug',
        'judul',
        'konten',
        'file',
        'file_nama_asli',
    ];
 
    // Konstanta slug — biar tidak typo di controller/blade
    const SELAYANG  = 'selayang';
    const GAMBARAN  = 'gambaran';
    const VISI      = 'visi';
    const STRUKTUR  = 'struktur';
 
    // Helper: ambil satu konten berdasarkan slug, dengan default jika belum ada di DB
    public static function bySlug(string $slug): self
    {
        return static::firstOrNew(['slug' => $slug], [
            'judul'  => self::defaultJudul($slug),
            'konten' => null,
        ]);
    }
 
    // Helper: ambil semua sekaligus, di-key-by slug → $profil['selayang']
    public static function semuaSebagaiMap()
    {
        $slugs = [self::SELAYANG, self::GAMBARAN, self::VISI, self::STRUKTUR];
        $existing = static::whereIn('slug', $slugs)->get()->keyBy('slug');
 
        $result = [];
        foreach ($slugs as $slug) {
            $result[$slug] = $existing[$slug] ?? static::bySlug($slug);
        }
        return $result;
    }
 
    // Judul default per slug (dipakai jika baris belum ada di DB)
    public static function defaultJudul(string $slug): string
    {
        return match ($slug) {
            self::SELAYANG => 'Selayang Pandang',
            self::GAMBARAN => 'Gambaran Umum',
            self::VISI     => 'Visi & Misi',
            self::STRUKTUR => 'Struktur Organisasi',
            default        => 'Profil',
        };
    }
 
    // Accessor: URL file lengkap
    public function getFileUrlAttribute(): ?string
    {
        return $this->file ? asset('storage/' . $this->file) : null;
    }
 
    // Accessor: cek apakah file adalah gambar (untuk preview) atau dokumen (untuk download)
    public function getFileIsImageAttribute(): bool
    {
        if (!$this->file) return false;
        $ext = strtolower(pathinfo($this->file, PATHINFO_EXTENSION));
        return in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
    }
}
