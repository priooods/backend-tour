<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class cabang extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'kota',
        'provinsi',
        'alamat',
        'code_cabang'
    ];
}
