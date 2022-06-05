<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntercambiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intercambios', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('transaccion_id');
            $table->Integer('superviviente_envia_id')->unsigned();
            $table->Integer('superviviente_recibe_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('cantidad');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('superviviente_envia_id')->references('id')->on('supervivientes');
            $table->foreign('superviviente_recibe_id')->references('id')->on('supervivientes');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intercambios');
    }
}
