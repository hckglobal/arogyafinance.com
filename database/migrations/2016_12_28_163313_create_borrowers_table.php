<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('application_id')->unsigned();
            $table->string('type');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('mobile_number');
            $table->string('email');
            $table->string('residence_type');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('address_line_1');
            $table->string('address_line_2');
            $table->string('marital_status');
            $table->integer('borrowers_income');
            $table->string('earning_since');
            $table->string('nature_of_income');
            $table->string('source_of_income');
            $table->string('employer_details');
            $table->string('name_of_firm');
            $table->integer('income_itr');
            $table->string('current_loan_emi');
            $table->string('education_expenses');
            $table->integer('house_rent');
            $table->string('number_of_dependants');
            $table->integer('other_earnings');
            $table->string('other_earnings_type');
            $table->integer('monthly_emi_possible');
            $table->string('id_proof_type');
            $table->string('id_proof_number');
            $table->string('pan_card_number');
            $table->string('aadhar_card_number');
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
        Schema::drop('borrowers');
    }
}
