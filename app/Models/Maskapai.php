<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maskapai extends Model
{
    use HasFactory;
    protected $hidden = ['pivot'];
    public $timestamps = false;
    protected $fillable = [
        'nama',
        'logo'
    ];
}
