<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemBelanja extends Model
{
    use HasFactory;

    public function my_item(){
        return $this->hasOne(Gudang::class,'id','gudang_id');
    }
}
