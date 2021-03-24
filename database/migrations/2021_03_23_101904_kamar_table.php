<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KamarTable extends Migration{
    public function up(){
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('kapasitas');
            $table->integer('harga');
            $table->unsignedBigInteger('hotel_id');
        });
        Schema::table('kamars', function($table){
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
        });
    }

    public function down(){
        Schema::dropIfExists('kamars');
    }
}
