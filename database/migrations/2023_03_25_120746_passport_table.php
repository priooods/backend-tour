<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PassportTable extends Migration{
    public function up(){
        Schema::create('passports', function (Blueprint $table) {
            $table->unsignedBigInteger('jamaah_id')->primary();
            $table->string('nama');
            $table->string('kota');
            $table->date('tgl_keluar');
            $table->date('tgl_habis');
        });
        Schema::table('passports', function($table){
            $table->foreign('jamaah_id')->references('id')->on('jamaahs')->onDelete('cascade');
        });
    }
    public function down(){
        Schema::dropIfExists('passports');
    }
}
