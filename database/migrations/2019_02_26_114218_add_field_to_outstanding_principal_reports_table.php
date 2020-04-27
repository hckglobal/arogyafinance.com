<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToOutstandingPrincipalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outstanding_principal_reports', function(Blueprint $table) {
            $table->string('overdue_in_months')->nullable();
            $table->integer('application_id')->unsigned();
            $table->decimal('processing_fee')->nullable();
            $table->decimal('document_charge')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outstanding_principal_reports', function($table) {
            $table->dropColumn('overdue_in_months');
            $table->dropColumn('application_id');
        });
    }
}
