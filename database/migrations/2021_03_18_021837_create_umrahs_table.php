<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUmrahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('umrahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->longText('code');
            $table->string('durasi');
            $table->string('jenis_paket');
            $table->string('tahun');
            $table->integer('kuota');
            $table->json('tgl_berangkat')->date();
            $table->json('tgl_pulang')->date();
            $table->string('hotel_mekkah');
            $table->string('hotel_madinah');
            $table->json('jenis_kamar');
            $table->json('biaya');
            $table->json('maskapai');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('umrahs');
    }
}
