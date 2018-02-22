<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationsCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations_cms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_translations_phrase')->unsigned();
            $table->string('lang', 2);
            $table->text('translate');

            $table->index('id_translations_phrase');

            $table->foreign('id_translations_phrase')
                ->references('id')->on('translations_phrases_cms')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('translations_cms');
    }
}