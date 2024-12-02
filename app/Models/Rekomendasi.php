<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rekomendasi extends Model
{
    use HasFactory;

    protected $table = 'tb_rekomendasi';
    protected $primaryKey = 'rekomendasi_id';
    protected $fillable = [
        'batas_id',
        'tgl_awal',
        'tgl_akhir',
    ];

    public function batas(): HasOne
    {
        return $this->hasone(Batas::class, 'batas_id', 'batas_id');
    }

    public function list_diskon(): HasMany
    {
        return $this->hasMany(Diskon::class, 'rekomendasi_id', 'rekomendasi_id');
    }
}
