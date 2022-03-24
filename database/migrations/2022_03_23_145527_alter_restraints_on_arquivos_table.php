<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRestraintsOnArquivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arquivos', function (Blueprint $table) {
            $table->string('formacao_academica')->unsigned()->nullable()->change();
            $table->string('dados_pessoais')->unsigned()->nullable()->change();
            $table->string('curriculum_vitae_lattes')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arquivos', function (Blueprint $table) {
            $table->string('formacao_academica')->unsigned()->nullable(false)->change();
            $table->string('dados_pessoais')->unsigned()->nullable(false)->change();
            $table->string('curriculum_vitae_lattes')->unsigned()->nullable(false)->change();
        });
    }
}
