<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutstandingPrincipalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outstanding_principal_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pin_number')->nullable();
            $table->string('loan_amount')->nullable();
            $table->string('emi')->nullable();
            $table->string('no_of_advance_emi')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_upto')->nullable();
            $table->date('disbursement_date')->nullable();
            $table->string('interest_rate',8,3)->nullable();
            $table->string('tenure')->nullable();
            $table->string('overdue_amount')->nullable();
            $table->string('interest')->nullable();
            $table->string('principal')->nullable();
            $table->string('outstanding_principal')->nullable();
            $table->string('total_collection')->nullable();
            $table->string('receivable')->nullable();
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
        Schema::drop('outstanding_principal_reports');
    }
}
