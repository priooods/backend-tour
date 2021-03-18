<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Belanja extends Model
{
    use HasFactory, Notifiable;

    protected $fillable =[
        'mukena',
        'koper',
        'peci',
        'kain',
        'batik',
        'sabuk',
        'jaket',
        'tas_ransel',
        'syal',
        'harga_mukena',
        'harga_koper',
        'harga_peci',
        'harga_kain',
        'harga_batik',
        'harga_sabuk',
        'harga_jaket',
        'harga_tas_ransel',
        'harga_syal',
        'total'
    ];
}
