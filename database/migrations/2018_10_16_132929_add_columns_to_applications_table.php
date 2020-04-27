<?php

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
        Schema::table('applications', function(Blueprint $table) {
            $table->integer('closer_reason_id')->unsigned()->nullable();
            $table->string('closer_note')->nullable();
            $table->date('closer_date')->nullable();
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
            $table->dropColumn('closer_reason_id');
            $table->dropColumn('closer_note');
            $table->dropColumn('closer_date');
             
        });
    }
}
