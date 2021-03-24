<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PesananTable extends Migration{
    public function up(){
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('umrah_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->unsignedBigInteger('maskapai_id');
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('kamar_id');
            $table->integer('bayar');
            $table->timestamps();
        });
        Schema::table('pesanans', function($table){
            $table->foreign('umrah_id')->references('id')->on('umrahs')->onDelete('cascade');
            $table->foreign('jadwal_id')->references('id')->on('jadwals')->onDelete('cascade');
            $table->foreign('maskapai_id')->references('id')->on('maskapais')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('kamar_id')->references('id')->on('kamars')->onDelete('cascade');
       });
    }

    public function down(){
        Schema::dropIfExists('pesanans');
    }
}
