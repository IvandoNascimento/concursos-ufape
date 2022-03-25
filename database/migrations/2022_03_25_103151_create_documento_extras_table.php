<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_extras', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('arquivo')->nullable();
            $table->unsignedBigInteger('concurso_id');
            $table->foreign('concurso_id')->references('id')->on('concursos');
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
        Schema::dropIfExists('documento_extras');
    }
}
