<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruang_pesan extends Model
{
    use HasFactory;

    protected $table = 'ruang_pesan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'id_admin',
        'pengirim',
        'pesan'
    ];
}
