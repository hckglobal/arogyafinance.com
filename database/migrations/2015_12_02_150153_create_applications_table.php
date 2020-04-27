<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->integer('cibil_score');
            $table->string('hospital_name');
            $table->string('approved_hospital_name');
            $table->integer('total_borrowers_income');
            $table->integer('calculated_income');
            $table->integer('calculated_loan_amount');
            $table->integer('calculated_loan_emi');
            $table->integer('calculated_loan_tenure');
            $table->integer('approved_loan_amount');
            $table->integer('approved_loan_emi');
            $table->integer('approved_loan_tenure');
            $table->string('treatment_type'); 
            $table->integer('estimated_cost'); 
            $table->integer('loan_required');
            $table->string('status');
            $table->integer('other_expense');
            $table->integer('requested_tenure');
            $table->integer('requested_emi');
            $table->decimal('interest_rate');
            $table->decimal('subvention');
            $table->decimal('processing_fee');
            $table->string('pin_number');
            $table->string('reference_code');
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
        Schema::drop('applications');
    }
}
