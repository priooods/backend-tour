<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Cabang extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'kota',
        'provinsi',
        'alamat',
        'code'
    ];

    public function mitra(){
        return $this->hasMany(Mitra::class,'cabang_id','id')->select("id","code","fullname","alamat","no_tlp","avatar");
    }
}
