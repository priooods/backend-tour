<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGudangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gudangs', function (Blueprint $table) {
            $table->id();
            $table->integer('mukena')->default(0);
            $table->integer('koper')->default(0);
            $table->integer('peci')->default(0);
            $table->integer('kain')->default(0);
            $table->integer('batik')->default(0);
            $table->integer('sabuk')->default(0);
            $table->integer('jaket')->default(0);
            $table->integer('tas_ransel')->default(0);
            $table->integer('syal')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        DB::table('gudangs')->insert(
            array(
                'mukena' => 0,
                'koper' => 0,
                'syal' => 0,
                'tas_ransel' => 0,
                'sabuk' => 0,
                'jaket' => 0,
                'batik' => 0,
                'kain' => 0,
                'peci' => 0,
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
        Schema::dropIfExists('gudangs');
    }
}
