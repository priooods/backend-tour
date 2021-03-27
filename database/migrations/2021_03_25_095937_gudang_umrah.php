<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GudangUmrah extends Migration{
    public function up(){
        Schema::create('gudang_umrahs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('umrah_id');
            $table->unsignedBigInteger('gudang_id');
            $table->string('condition')->nullable();
        });

        Schema::table('gudang_umrahs', function($table){
            $table->foreign('umrah_id')->references('id')->on('umrahs')->onDelete('cascade');
            $table->foreign('gudang_id')->references('id')->on('gudangs')->onDelete('cascade');
        });
    }

    public function down(){
        Schema::dropIfExists('gudang_umrahs');
    }
}
