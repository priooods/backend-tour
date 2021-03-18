<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Mitra extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'fullname',
        'password',
        'log',
        'username',
        'no_tlp',
        'alamat',
        'cabang',
        'code',
        'code_agent',
        'avatar',
    ];
}
