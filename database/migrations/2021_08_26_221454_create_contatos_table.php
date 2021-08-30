<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('email', 150)->nullable();
            $table->string('endereco', 100)->nullable();
            $table->unsignedBigInteger('grupo_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('grupo_id')->references('id')->on('grupos');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contatos', function(Blueprint $table){
            $table->dropForeign('contatos_user_id_foreign');
        });
        Schema::table('contatos', function(Blueprint $table){
            $table->dropForeign('contatos_grupo_id_foreign');
        });
        Schema::dropIfExists('contatos');
    }
}
