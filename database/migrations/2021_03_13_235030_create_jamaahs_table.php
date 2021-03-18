<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateJamaahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jamaahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nama_ayah');
            $table->bigInteger('nomer_ktp');
            $table->string('ttl');
            $table->bigInteger('nomer_passport')->unique()->nullable();
            $table->enum('gender',['Pria','Wanita']);
            $table->string('negara'); 
            $table->string('alamat');
            $table->string('desa');
            $table->string('kecamatan');
            $table->string('kota');
            $table->string('provinsi');
            $table->integer('kode_pos')->nullable();
            $table->bigInteger('nomer_tlp');
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->string('status_haji')->nullable();
            $table->string('paket_haji')->nullable();
            $table->string('paket_umrah')->nullable();
            $table->string('nama_mitra');
            $table->bigInteger('biaya_dibayar');
            $table->string('nama_passport')->nullable();
            $table->string('kota_passport')->nullable();
            $table->date('tgl_habis_passport')->nullable();
            $table->date('tgl_keluar_passport')->nullable();
            $table->string('darah');
            $table->string('nama_mahram');
            $table->string('hubungan_mahram')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jamaahs');
    }
}
