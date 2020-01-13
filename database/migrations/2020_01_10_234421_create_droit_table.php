<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDroitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('droit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('id_utilisateur');
            $table->integer('id_projet');
            $table->enum('role', array('7', '8'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('droit');
    }
}
