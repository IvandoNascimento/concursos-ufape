<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConcursoIdToMembroBancasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('membro_bancas', function (Blueprint $table) {
            $table->boolean('chefe')->nullable();
            $table->unsignedBigInteger('concurso_id')->nullable();
            $table->foreign('concurso_id')->references('id')->on('concursos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('membro_bancas', function (Blueprint $table) {
            $table->dropColumn('chefe');
            $table->dropColumn('concurso_id');
        });
    }
}
