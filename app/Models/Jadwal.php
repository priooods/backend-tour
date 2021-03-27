<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $hidden = ['id','umrah_id'];
    protected $fillable = [
        'berangkat',
        'pulang',
        'umrah_id'
    ];
}
