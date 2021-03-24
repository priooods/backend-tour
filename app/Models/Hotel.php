<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $hidden = ['pivot'];
    public $timestamps = false;
    protected $fillable = [
        'nama',
        'alamat',
        'kota',
        'highlight'
    ];

    public function kamar(){
        return $this->hasMany(Kamar::class,'hotel_id');
    }
}
