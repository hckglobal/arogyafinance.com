<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text_en');
            $table->text('text_hi');
            $table->text('text_mr');
            $table->text('text_gu');
            $table->text('text_bn');
            $table->integer('parameter_id')->unsigned();
            $table->integer('level_id')->unsigned();
            $table->timestamps();


            $table->foreign('parameter_id')->references('id')->on('parameters')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('level_id')->references('id')->on('levels')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('questions');
    }
}
