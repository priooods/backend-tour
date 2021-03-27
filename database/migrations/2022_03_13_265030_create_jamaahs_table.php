<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateJamaahsTable extends Migration{
    public function up(){
        Schema::create('jamaahs', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('pesanan_id')->nullable();
            $table->string('nama_lengkap');
            $table->string('nama_ayah');
            $table->bigInteger('no_ktp');
            $table->string('ttl');
            $table->enum('gender',['Pria','Wanita']);
            $table->string('negara');
            $table->string('alamat');
            $table->string('desa');
            $table->string('kecamatan');
            $table->string('kota');
            $table->string('provinsi');
            $table->integer('kode_pos')->nullable();
            $table->bigInteger('no_telp');
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->string('status_haji')->nullable();
            $table->string('darah');
            $table->string('nama_mahram');
            $table->string('hubungan_mahram')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
        Schema::table('jamaahs', function($table){
            $table->foreign('pesanan_id')->references('id')->on('pesanans')->onDelete('cascade');
        });
    }

    public function down(){
        Schema::dropIfExists('jamaahs');
    }
}
