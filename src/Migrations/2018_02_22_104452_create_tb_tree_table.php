<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbTreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_tree', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->integer('lft');
            $table->integer('rgt');
            $table->integer('depth');
            $table->string('title');
            $table->text('description');
            $table->string('slug');
            $table->string('template', 120);
            $table->string('picture');
            $table->text('additional_pictures');
            $table->tinyInteger('is_active');
            $table->string('seo_title');
            $table->string('seo_description');
            $table->string('seo_keywords');
            $table->tinyInteger('is_show_in_menu');
            $table->tinyInteger('is_show_in_footer_menu	');
            $table->timestamps();

            $table->index('parent_id');
            $table->index('lft');
            $table->index('rgt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tb_tree');
    }
}
