<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Jamaah extends Model
{
    use HasFactory, Notifiable;
    public $hidden = ['pesanan_id'];
    protected $fillable = [
        'code',
        'pesanan_id',
        'passport_id',
        'mitra_id',
        'nama_lengkap',
        'nama_ayah',
        'no_ktp',
        'ttl',
        'gender',
        'negara',
        'alamat',
        'desa',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'no_telp',
        'pendidikan',
        'pekerjaan',
        'status_haji',
        'darah',
        'nama_mahram',
        'hubungan_mahram',
    ];

    public function pesanan(){
        return $this->belongsTo(Pesanan::class,'pesanan_id','id');
    }
    public function passport(){
        return $this->hasOne(Passport::class,'jamaah_id');
    }
}
