<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGudangsTable extends Migration{
    public function up(){
        Schema::create('gudangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->integer('harga')->default(0);
            $table->integer('stok')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down(){
        Schema::dropIfExists('gudangs');
    }
}
