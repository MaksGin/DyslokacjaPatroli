<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatrolWydzialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patrol_wydzial', function (Blueprint $table) {
            $table->unsignedBigInteger('patrol_id');
            $table->unsignedBigInteger('wydzial_id');

            $table->foreign('patrol_id')->references('id')->on('patrols')->onDelete('cascade');
            $table->foreign('wydzial_id')->references('id')->on('wydzialy')->onDelete('cascade');

            $table->primary(['patrol_id', 'wydzial_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patrol_wydzial');
    }
}

