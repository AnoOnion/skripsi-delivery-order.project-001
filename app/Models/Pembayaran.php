<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'id_admin',
        'kode_pembayaran',
        'status_order',
        'status_kurir',
        'status_bayar',
        'metode_bayar',
        'jumlah',
        'jumlah_fee',
        'jumlah_tunai',
        'jumlah_kembalian',
        'latitude',
        'longitude',
        'alamat_lengkap'
    ];
}
