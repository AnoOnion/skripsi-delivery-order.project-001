<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok_produk extends Model
{
    use HasFactory;

    protected $table = 'stok_produk';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_admin',
        'id_produk',
        'stok_awal',
        'stok_sementara',
        'stok_akhir',
        'harga_beli',
        'harga_jual'
    ];
}
