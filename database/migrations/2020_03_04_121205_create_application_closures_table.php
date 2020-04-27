<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationClosuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_closures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('application_id')->unsigned();
            $table->date('closure_date');
            $table->integer('closure_amount')->default(0);
            $table->integer('overdue_amount')->default(0);
            $table->integer('principal_outstanding')->default(0);
            $table->integer('adjusted_principal')->default(0);
            $table->integer('adjusted_outstanding_principal')->default(0);
            $table->integer('adjusted_dishonor')->default(0);
            $table->integer('adjusted_late_payment')->default(0);
            $table->integer('adjusted_legal')->default(0);
            $table->integer('adjusted_pre_payment')->default(0);
            $table->integer('adjusted_waived_off')->default(0);
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
        Schema::drop('application_closures');
    }
}
