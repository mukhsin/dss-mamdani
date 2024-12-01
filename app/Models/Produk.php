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
    ];

    public function getIdAttribute()
    {
        return $this->produk_id;
    }

    public function getNameAttribute()
    {
        return $this->nama_produk;
    }

}
