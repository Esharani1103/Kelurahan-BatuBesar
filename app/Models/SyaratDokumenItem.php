<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SyaratDokumenItem extends Model
{
    use HasFactory;

    protected $table    = 'syarat_dokumen_item';
    protected $fillable = ['syarat_dokumen_id','teks','urutan'];
    protected $casts    = ['urutan' => 'integer'];

    public function syarat()
    {
        return $this->belongsTo(SyaratDokumen::class, 'syarat_dokumen_id');
    }
}