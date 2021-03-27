<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Mitra extends Model
{
    use HasFactory, Notifiable;
    public $jamaah = 0;
    public $mjamaah = 0;
    protected $hidden = [
        'code_agent'
    ];
    protected $fillable = [
        'fullname',
        'password',
        'log',
        'username',
        'no_tlp',
        'alamat',
        'cabang_id',
        'code',
        'code_agent',
        'avatar',
    ];

    public function jamaah()
    {
        return;
        // return $this->hasMany(::class, 'foreign_key', 'local_key');
    }
}
