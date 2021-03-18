<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Aset extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'mukena',
        'koper',
        'peci',
        'kain',
        'batik',
        'sabuk',
        'jaket',
        'tas_ransel',
        'syal',
    ];
}
