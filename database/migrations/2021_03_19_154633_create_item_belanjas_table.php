<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemBelanjasTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_belanjas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('belanja_id');
            $table->unsignedBigInteger('gudang_id');
            $table->integer('total');
        });


        Schema::table('item_belanjas', function($table){
            $table->foreign('belanja_id')->references('id')->on('belanjas')->onDelete('cascade');
            $table->foreign('gudang_id')->references('id')->on('gudangs')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_belanjas');
    }
}
