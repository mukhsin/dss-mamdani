<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Batas extends Model
{
    use HasFactory;

    protected $table = 'tb_batas';
    protected $primaryKey = 'batas_id';
    protected $fillable = [
        'halaman',
        'batas_kecil_modal',
        'batas_sedang_modal',
        'batas_besar_modal',
        'batas_kecil_keuntungan',
        'batas_sedang_keuntungan',
        'batas_besar_keuntungan',
        'batas_kecil_diskon',
        'batas_sedang_diskon',
        'batas_besar_diskon',
    ];

    public function rekomendasi(): BelongsTo
    {
        return $this->belongsTo(Rekomendasi::class, 'batas_id', 'batas_id');
    }
}
