<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Laporan_topup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'laporan_topup';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'kode_external',
        'metode',
        'bank_kode',
        'jumlah',
        'deskripsi'
    ];
}
