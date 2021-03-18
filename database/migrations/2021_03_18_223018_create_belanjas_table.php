<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBelanjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('belanjas', function (Blueprint $table) {
            $table->id();
            $table->integer('mukena')->default(0);
            $table->integer('harga_mukena')->default(0);
            $table->integer('koper')->default(0);
            $table->integer('harga_koper')->default(0);
            $table->integer('peci')->default(0);
            $table->integer('harga_peci')->default(0);
            $table->integer('kain')->default(0);
            $table->integer('harga_kain')->default(0);
            $table->integer('batik')->default(0);
            $table->integer('harga_batik')->default(0);
            $table->integer('sabuk')->default(0);
            $table->integer('harga_sabuk')->default(0);
            $table->integer('jaket')->default(0);
            $table->integer('harga_jaket')->default(0);
            $table->integer('tas_ransel')->default(0);
            $table->integer('harga_tas_ransel')->default(0);
            $table->integer('syal')->default(0);
            $table->integer('harga_syal')->default(0);
            $table->integer('total')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        DB::table('belanjas')->insert(
            array(
                'mukena' => 0,
                'harga_mukena' => 0,
                'koper' => 0,
                'harga_koper' => 0,
                'syal' => 0,
                'harga_syal' => 0,
                'tas_ransel' => 0,
                'harga_tas_ransel' => 0,
                'sabuk' => 0,
                'harga_sabuk' => 0,
                'jaket' => 0,
                'harga_jaket' => 0,
                'batik' => 0,
                'harga_batik' => 0,
                'kain' => 0,
                'harga_kain' => 0,
                'peci' => 0,
                'harga_peci' => 0,
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('belanjas');
    }
}
