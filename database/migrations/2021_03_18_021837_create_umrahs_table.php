<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUmrahsTable extends Migration{
    public function up(){
        Schema::create('umrahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->longText('code');
            $table->string('durasi');
            $table->string('jenis_paket');
            $table->string('tahun');
            $table->integer('kuota');
            $table->integer('biaya');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    public function down(){
        Schema::dropIfExists('umrahs');
    }
}
