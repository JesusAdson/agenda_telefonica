<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numeros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contato_id');
            $table->string('numero_telefone');
            $table->timestamps();

            $table->foreign('contato_id')->references('id')->on('contatos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('numeros', function(Blueprint $table){
            $table->dropForeign('numeros_contato_id_foreign');
        });
        Schema::dropIfExists('numeros');
    }
}
