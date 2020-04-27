<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('password');
            $table->string('remember_token');
            $table->timestamps();
        });
       
        Schema::create('assets', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('application_id')->unsigned();;
            $table->string('name');
            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('applications')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('family_members', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('application_id')->unsigned();;
            $table->string('first_name');
            $table->string('last_name');
            $table->string('relation');
            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('applications')
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
        Schema::drop('admins');
        Schema::drop('assets');
        Schema::drop('family_member');
    }
}
