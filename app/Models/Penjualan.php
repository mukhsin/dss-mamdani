<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'tb_penjualan';
    protected $primaryKey = 'penjualan_id';
    protected $fillable = [
        'tgl_pesanan',
        'qty',
        'harga_jual',
    ];
    protected $appends = [
        'tanggal_pesanan',
        'total_harga',
    ];

    public function getTanggalPesananAttribute(): String
    {
        if (!$this->tgl_pesanan) return '';
        return Carbon::createFromFormat('Y-m-d', $this->tgl_pesanan)->translatedFormat('d F Y');
    }

    public function getTotalHargaAttribute(): float
    {
        return ((int) $this->qty) * ((float) $this->harga_jual);
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }
}
