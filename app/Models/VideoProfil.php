<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoProfil extends Model
{
    use HasFactory;

    protected $table = 'video_profil';

    protected $fillable = [
        'judul',
        'url_youtube',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->latest();
    }

    public function getIsYoutubeAttribute(): bool
    {
        return !empty($this->url_youtube);
    }

   public function getYoutubeIdAttribute(): ?string
{
    if (!$this->url_youtube) {
        return null;
    }

    // jika sudah berupa ID
    if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $this->url_youtube)) {
        return $this->url_youtube;
    }

    // jika berupa URL
    preg_match(
        '%(?:youtube(?:-nocookie)?\.com/(?:[^/\n\s]+/\S+/|(?:v|e(?:mbed)?)/|\S*?[?&]v=)|youtu\.be/)([a-zA-Z0-9_-]{11})%',
        $this->url_youtube,
        $matches
    );

    return $matches[1] ?? null;
}

    public function getEmbedUrlAttribute(): ?string
    {
        return $this->youtube_id
            ? 'https://www.youtube.com/embed/' . $this->youtube_id
            : null;
    }
}