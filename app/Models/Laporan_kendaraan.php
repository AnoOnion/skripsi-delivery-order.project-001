<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan_kendaraan extends Model
{
    use HasFactory;

    protected $table = 'laporan_kendaraan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_admin',
        'id_kendaraan',
        'kode_laporan',
        'status',
        'catatan'
    ];
}
