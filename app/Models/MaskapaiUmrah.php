<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaskapaiUmrah extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'umrah_id',
        'maskapai_id'
    ];
}
