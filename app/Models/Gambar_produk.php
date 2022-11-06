<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gambar_produk extends Model
{
    use HasFactory;

    protected $table = 'gambar_produk';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_produk',
        'path'
    ];
}
