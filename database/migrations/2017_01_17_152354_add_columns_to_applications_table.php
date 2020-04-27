htj<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('location');
            $table->date('valid_from');
            $table->date('valid_upto');
            $table->date('disbursement_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function(Blueprint $table) {
        $table->dropColumn('location');
        $table->dropColumn('valid_from');
        $table->dropColumn('valid_upto');
        $table->dropColumn('disbursement_date');
        
        });
    }
}
