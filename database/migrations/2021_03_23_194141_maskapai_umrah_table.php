<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MaskapaiUmrahTable extends Migration{
    public function up(){
        Schema::create('maskapai_umrahs', function (Blueprint $table) {
            $table->unsignedBigInteger('umrah_id');
            $table->unsignedBigInteger('maskapai_id');
        });
        Schema::table('maskapai_umrahs', function($table){
            $table->foreign('umrah_id')->references('id')->on('umrahs')->onDelete('cascade');
            $table->foreign('maskapai_id')->references('id')->on('maskapais')->onDelete('cascade');
        });
    }

    public function down(){
        Schema::dropIfExists('maskapai_umrahs');
    }
}
