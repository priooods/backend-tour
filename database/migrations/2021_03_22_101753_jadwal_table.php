<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JadwalTable extends Migration{
    public function up(){
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->date('berangkat');
            $table->date('pulang');
            $table->unsignedBigInteger('umrah_id')->nullable();
        });
        Schema::table('jadwals', function($table){
            $table->foreign('umrah_id')->references('id')->on('umrahs')->onDelete('cascade');
        });
    }

    public function down(){
        Schema::dropIfExists('jadwals');
    }
}
