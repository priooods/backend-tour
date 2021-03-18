<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asets', function (Blueprint $table) {
            $table->id();
            $table->string('code_jamaah');
            $table->integer('mukena')->nullable();
            $table->integer('koper')->nullable();
            $table->integer('peci')->nullable();
            $table->integer('kain')->nullable();
            $table->integer('batik')->nullable();
            $table->integer('sabuk')->nullable();
            $table->integer('jaket')->nullable();
            $table->integer('tas_ransel')->nullable();
            $table->integer('syal')->nullable();
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
        Schema::dropIfExists('asets');
    }
}