<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diskon extends Model
{
    use HasFactory;

    protected $table = 'tb_diskon';
    protected $primaryKey = 'diskon_id';
    protected $fillable = [
        'jenis_diskon',
        'besaran_diskon',
        'keterangan',
    ];

    public function list_penjualan(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'diskon_id', 'diskon_id');
    }
}
