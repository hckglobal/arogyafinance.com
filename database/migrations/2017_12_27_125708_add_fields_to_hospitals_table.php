<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->string('acc_name');
            $table->string('acc_number');
            $table->string('bank_name');
            $table->string('bank_branch');
            $table->string('ifsc_code');
            $table->string('acc_type');
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hospitals', function(Blueprint $table) {
            $table->dropColumn('acc_name');
            $table->dropColumn('acc_number');
            $table->dropColumn('bank_name');
            $table->dropColumn('bank_branch');
            $table->dropColumn('ifsc_code');
            $table->dropColumn('acc_type');
        });
    }
}
