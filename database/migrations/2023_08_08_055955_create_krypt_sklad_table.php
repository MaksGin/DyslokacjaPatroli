<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKryptSkladTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krypt_sklad', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('krypt_id');
            $table->unsignedBigInteger('sklad_id');


            $table->foreign('krypt_id')->references('id')->on('kryptonims');
            $table->foreign('sklad_id')->references('id')->on('sklads');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('krypt_sklad');
    }
}
