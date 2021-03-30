<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMitrasTable extends Migration{
    public function up(){
        Schema::create('mitras', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedBigInteger('code_agent')->nullable();
            $table->string('fullname');
            $table->string('username')->unique();
            $table->longText('alamat');
            $table->unsignedBigInteger('cabang_id')->nullable();
            $table->bigInteger('no_tlp');
            $table->text('password');
            $table->integer('log');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::table('mitras', function($table){
            $table->foreign('code_agent')->references('id')->on('mitras')->onDelete('cascade');
            $table->foreign('cabang_id')->references('id')->on('cabangs')->onDelete('cascade');
        });
    }

    public function down(){
        Schema::dropIfExists('mitras');
    }
}
