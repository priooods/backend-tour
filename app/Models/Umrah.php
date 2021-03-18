<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Umrah extends Model
{
    use HasFactory;

    protected $casts = [
        'nama',
        'durasi',
        'code',
        'jenis_paket',
        'tahun',
        'kuota',
        'tgl_berangkat' => 'array',
        'tgl_pulang' => 'array',
        'hotel_mekkah',
        'hotel_madinah',
        'jenis_kamar' => 'array',
        'biaya' => 'array',
        'maskapai' => 'array'
    ];
}
