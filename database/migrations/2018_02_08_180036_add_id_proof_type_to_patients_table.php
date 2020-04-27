<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdProofTypeToPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('pan_card')->nullable();
            $table->string('aadhar_card')->nullable();
            $table->string('driving_id')->nullable();
            $table->string('voting_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('patients', function(Blueprint $table) {
            $table->dropColumn('pan_card');
            $table->dropColumn('aadhar_card');
            $table->dropColumn('driving_id');
            $table->dropColumn('voting_id');
            
        });
    }
}
