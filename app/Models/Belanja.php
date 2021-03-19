<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Belanja extends Model
{
    use HasFactory, Notifiable;

    protected $fillable =[
        'mukena',
        'koper',
        'peci',
        'kain',
        'batik',
        'sabuk',
        'jaket',
        'tas_ransel',
        'syal',
        'harga_mukena',
        'harga_koper',
        'harga_peci',
        'harga_kain',
        'harga_batik',
        'harga_sabuk',
        'harga_jaket',
        'harga_tas_ransel',
        'harga_syal',
        'total'
    ];

    public function my_belanja(){
        return $this->hasMany(ItemBelanja::class,'belanja_id');
    }
    // public function my_item(){
    //     return $this->hasManyThrough(Gudang::class, ItemBelanja::class, 'gudang_id', 'gudang_id');
    // }
}
