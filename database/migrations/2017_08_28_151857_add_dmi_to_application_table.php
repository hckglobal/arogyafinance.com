<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDmiToApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('dmi_status')->nullable();
            $table->date('dmi_issue_date')->nullable();
            $table->boolean('dmi_sent')->nullable();
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
        $table->dropColumn('dmi_status');
        $table->dropColumn('dmi_issue_date');
        $table->dropColumn('dmi_sent');
        });
    }
}
