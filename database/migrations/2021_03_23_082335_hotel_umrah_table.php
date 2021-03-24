<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HotelUmrahTable extends Migration{
    public function up(){
        Schema::create('hotel_umrahs', function (Blueprint $table) {
            $table->unsignedBigInteger('umrah_id');
            $table->unsignedBigInteger('hotel_id');
        });
        Schema::table('hotel_umrahs', function($table){
            $table->foreign('umrah_id')->references('id')->on('umrahs')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
        });
    }

    public function down(){
        Schema::dropIfExists('hotel_umrahs');
    }
}
