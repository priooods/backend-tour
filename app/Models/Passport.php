<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $hidden = ['jamaah_id'];
    protected $fillable = [
        'nama',
        'kota',
        'tgl_keluar',
        'tgl_habis'
    ];
}
