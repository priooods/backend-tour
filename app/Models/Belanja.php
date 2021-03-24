<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Belanja extends Model
{
    use HasFactory, Notifiable;

    protected $fillable =[
        'total'
    ];

    public function my_belanja(){
        return $this->hasMany(ItemBelanja::class,'belanja_id');
    }
}
