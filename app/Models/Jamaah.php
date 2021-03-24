<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Jamaah extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'code',
        'pesanan_id',
        'aset_id',
        'nama_lengkap',
        'nama_ayah',
        'nomer_ktp',
        'ttl',
        'nomer_passport',
        'gender',
        'negara',
        'alamat',
        'desa',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        'nomer_tlp',
        'pendidikan',
        'pekerjaan',
        'status_haji',
        'tgl_keluar_passport',
        'tgl_habis_passport',
        'nama_passport',
        'kota_passport',
        'darah',
        'nama_mahram',
        'hubungan_mahram',
    ];
}
