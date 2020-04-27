<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeChequeDateToRepaymentCheques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repayment_cheques', function (Blueprint $table) {
        $table->string('type');
        $table->date('cheque_date');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repayment_cheques', function (Blueprint $table) {
             $table->dropColumn('type');
             $table->dropColumn('cheque_date')->nullable();
                  
        });
    }
}
