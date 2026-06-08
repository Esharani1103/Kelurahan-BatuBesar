<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoProfil extends Model
{
    use HasFactory;

    protected $table    = 'video_profil';
    protected $fillable = ['judul','file_video','url_youtube','aktif'];
    protected $casts    = ['aktif' => 'boolean'];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->latest();
    }

    public function getIsYoutubeAttribute(): bool
    {
        return !empty($this->url_youtube);
    }

    public function getEmbedUrlAttribute(): ?string
    {
        if (!$this->url_youtube) return null;

        preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            $this->url_youtube,
            $matches
        );

        if (!empty($matches[1])) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        if (strlen($this->url_youtube) === 11) {
            return 'https://www.youtube.com/embed/' . $this->url_youtube;
        }
        return null;
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_video ? asset('storage/' . $this->file_video) : null;
    }
}