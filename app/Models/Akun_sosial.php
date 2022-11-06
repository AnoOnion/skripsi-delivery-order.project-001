<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun_sosial extends Model
{
    use HasFactory;

    protected $table = 'akun_sosial';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'provider',
        'provider_id_user'
    ];
}
