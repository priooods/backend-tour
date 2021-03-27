<?php

namespace App\Models;

use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Umrah extends Model{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis_paket',
        'durasi',
        'code',
        'tahun',
        'kuota',
        'biaya'
    ];

    public function jadwals(){
        return $this->hasMany(Jadwal::class, 'umrah_id');
    }
    public function jadwal(){
        return $this->hasOne(Jadwal::class, 'umrah_id');
    }
    public function hotels(){
        return $this->hasMany(HotelUmrah::class);//->as('hotel_umrah');
    }
    public function maskapais(){
        return $this->hasMany(MaskapaiUmrah::class, 'umrah_id');
    }
    public function asets(){
        return $this->hasMany(GudangUmrah::class, 'umrah_id');
    }

    // public function hotels(){
    //     return $this->hasManyThrough(HotelUmrah::class, Hotel::class, 'id', 'umrah_id');
    // }
    public function hotel(){
        return $this->belongsToMany(Hotel::class, 'hotel_umrahs', 'umrah_id', 'hotel_id');
    }
    public function maskapai(){
        return $this->belongsToMany(Maskapai::class, 'maskapai_umrahs');
    }
    public function aset(){
        return $this->belongsToMany(Gudang::class, 'gudang_umrahs', 'umrah_id', 'gudang_id');
    }
}
