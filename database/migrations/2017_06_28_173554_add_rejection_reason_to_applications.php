<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRejectionReasonToApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* Schema::table('applications', function (Blueprint $table) {
            $table->integer('rejection_reason_id')->unsigned()->nullable();

            $table->foreign('rejection_reason_id')->references('id')->on('rejection_reasons')
                ->onUpdate('cascade')->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function(Blueprint $table) {
        $table->dropColumn('rejection_reason_id');
        });
    }
}
