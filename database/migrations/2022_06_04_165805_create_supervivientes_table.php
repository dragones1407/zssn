<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupervivientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervivientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('edad');
            $table->enum('genero', ['Hombre', 'Mujer']);
            $table->string('latitud');
            $table->string('longitud');
            $table->boolean('infectado')->default(0);
            $table->integer('reportado')->default(0);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supervivientes');
    }
}
