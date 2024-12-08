<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'tb_produk';
    protected $primaryKey = 'produk_id';
    protected $fillable = [
        'nama_produk',
        'berat_produk',
        'harga_modal',
    ];
    protected $appends = [
        'id',
        'name',
        // 'hasil_diskon',
        // 'harga_jual',
        'qty',
        // 'harga_setelah_diskon',
        // 'total_keuntungan',
    ];

    public function getIdAttribute()
    {
        return $this->produk_id;
    }

    public function getNameAttribute()
    {
        return $this->nama_produk;
    }

    // public function getHasilDiskonAttribute(): int
    // {
    //     return floor(rand(1, 3)) * 10;
    // }

    // public function getHargaJualAttribute(): int
    // {
    //     if (!array_key_exists('list_penjualan', $this->relations)) {
    //         return 1.5 * $this->harga_modal;
    //     }
    //
    //     $harga_jual = 0;
    //     foreach ($this->relations['list_penjualan'] as $key => $value) {
    //         if ($value->harga_jual > $harga_jual) {
    //             $harga_jual = $value->harga_jual;
    //         }
    //     }
    //
    //     return $harga_jual;
    // }

    public function getQtyAttribute(): int
    {
        if (!array_key_exists('list_penjualan', $this->relations)) {
            return 0;
        }

        $qty = 0;
        foreach ($this->relations['list_penjualan'] as $key => $value) {
            if ($value->qty > $qty) {
                $qty = $qty + $value->qty;
            }
        }

        return $qty;
    }

    // public function getHargaSetelahDiskonAttribute(): int
    // {
    //     return $this->harga_jual * (100 - $this->hasil_diskon);
    // }

    // public function getTotalKeuntunganAttribute(): int
    // {
    //     return $this->harga_jual - $this->harga_modal;
    // }

    public function list_penjualan(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'produk_id', 'produk_id');
    }

}
