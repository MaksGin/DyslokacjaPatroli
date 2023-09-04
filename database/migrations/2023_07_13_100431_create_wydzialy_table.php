<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use DB;
class CreateWydzialyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wydzialy', function (Blueprint $table) {
            $table->id();
            $table->string('nazwa');
            $table->timestamps();
        });
        DB::insert("INSERT INTO wydzialy (nazwa) VALUES ('Wydział Patrolowo Interwencyjny')");
        B::insert("INSERT INTO wydzialy (nazwa) VALUES ('Wydział Ruchu Drogowego')");
        B::insert("INSERT INTO wydzialy (nazwa) VALUES ('Rewir Dzielnicowych')");
        B::insert("INSERT INTO wydzialy (nazwa) VALUES ('Wydział Kryminalny')");
        B::insert("INSERT INTO wydzialy (nazwa) VALUES ('Wydział Prewencji')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wydzialy');
    }
}
