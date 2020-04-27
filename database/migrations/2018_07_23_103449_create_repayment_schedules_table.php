<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepaymentSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repayment_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('application_id')->unsigned();
            $table->string('month_at');
            $table->string('type');
            $table->date('emi_month');
            $table->integer('emi');
            $table->decimal('principal');
            $table->decimal('interest');
            $table->decimal('outstanding_principal')->nullable();
            $table->decimal('amount_received')->nullable();
            $table->date('emi_payment_date')->nullable();
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
        Schema::drop('repayment_schedules');
    }
}
