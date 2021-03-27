<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PesananTable extends Migration{
    public function up(){
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mitra_id')->nullable();
            $table->unsignedBigInteger('umrah_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->unsignedBigInteger('maskapai_id')->nullable();
            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->unsignedBigInteger('kamar_id')->nullable();
            $table->integer('bayar')->default(0);
            $table->timestamps();
        });
        Schema::table('pesanans', function($table){
            $table->foreign('mitra_id')->references('id')->on('mitras')->onDelete('cascade');
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
