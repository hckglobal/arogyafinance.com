<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountRepaymentSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_repayment_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('application_id')->unsigned();
            $table->string('type');
            $table->date('emi_month');
            $table->integer('emi');
            $table->decimal('principal');
            $table->decimal('interest');
            $table->decimal('outstanding_principal');
            $table->decimal('amount_received')->default(0);
            $table->date('emi_payment_date')->nullable();
            $table->decimal('principal_adjustment_amount')->default(0);
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
        Schema::drop('account_repayment_schedules');
    }
}
