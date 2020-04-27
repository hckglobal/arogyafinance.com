<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDelayChargesToAccountRepaymentSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_repayment_schedules', function(Blueprint $table) {
            $table->string('delay_charges')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_repayment_schedules', function(Blueprint $table) {
            $table->dropColumn('delay_charges');
        });
    }
}
