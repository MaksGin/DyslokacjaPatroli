<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatrolsTable extends Migration
{
    public function up()
    {
        Schema::create('patrols', function (Blueprint $table) {
            $table->id();
            $table->string('kom');
            $table->date('data');
            $table->string('g_rozp');
            $table->string('g_zak');
            $table->string('uwagi');
            $table->string('rejon');
            $table->string('krypt');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        
        Schema::create('patrol_wydzial', function (Blueprint $table) {
            $table->unsignedBigInteger('patrol_id');
            $table->unsignedBigInteger('wydzial_id');
            
            $table->foreign('patrol_id')->references('id')->on('patrols')->onDelete('cascade');
            $table->foreign('wydzial_id')->references('id')->on('wydzialy')->onDelete('cascade');
            
            $table->primary(['patrol_id', 'wydzial_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('patrol_department');
        Schema::dropIfExists('patrols');
    }
}

