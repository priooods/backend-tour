<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MaskapaiTable extends Migration{
    public function up(){
        Schema::create('maskapais', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('logo');
        });
    }

    public function down(){
        Schema::dropIfExists('maskapais');
    }
}