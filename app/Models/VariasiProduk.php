<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariasiProduk extends Model
{
    use HasFactory;

    protected $table = 'tb_variasi_produk';
    protected $primaryKey = 'variasi_id';

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }

}
