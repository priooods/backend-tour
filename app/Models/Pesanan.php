<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'umrah_id',
        'mitra_id',
        'jadwal_id',
        'maskapai_id',
        'hotel_id',
        'kamar_id',
        'bayar'
    ];
    public function jamaah(){
        return $this->hasMany(Jamaah::class,'pesanan_id');
    }

    public function umrah(){
        return $this->hasOne(Umrah::class,'id','umrah_id');
    }
    public function jadwal(){
        return $this->hasOne(Jadwal::class,'id','jadwal_id');
    }

    public function aset(){
        return $this->hasMany(GudangUmrah::class,'umrah_id','umrah_id');
    }
    // public function umrahc(){
    //     return $this->hasOne(Umrah::class,'id','umrah_id')
    //     ->whereHas('umrah','biaya' <= 'bayar']);
    // }
}
