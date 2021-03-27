<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Belanja extends Model
{
    use HasFactory, Notifiable;
    public $name;
    protected $fillable =[
        'operator_id',
        'total'
    ];

    public function item(){
        // $a = ;
        return $this->hasMany(ItemBelanja::class,'belanja_id');
    }
    public function items(){
        return $this->belongsToMany(Gudang::class,'item_belanjas','belanja_id');
    }
}
