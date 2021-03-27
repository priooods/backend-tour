<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemBelanja extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $hidden = [
        // 'gudang_id',
        'id',
        'belanja_id',
        'my_item'
    ];
    protected $fillable = [
        'gudang_id',
        'total'
    ];

    public function my_item(){
        return $this->hasOne(Gudang::class,'id','gudang_id');
    }
    public function nama(){
        $A = $this->hasOne(Gudang::class,'id','gudang_id');
        return ["anjir"=>"aa"];
    }
}
