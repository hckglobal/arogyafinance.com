<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToRepaymentSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('repayment_schedules', function(Blueprint $table) {
            $table->string('narration')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('source')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repayment_schedules', function(Blueprint $table) {
            $table->dropColumn('narration');
            $table->dropColumn('ref_no');
            $table->dropColumn('source');
        });
    }
}
