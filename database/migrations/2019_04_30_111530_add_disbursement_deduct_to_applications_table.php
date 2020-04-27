<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisbursementDeductToApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function(Blueprint $table) {
            $table->boolean('advance_emi_deduct')->nullable()->default(0);
            $table->boolean('subvention_deduct')->nullable()->default(0);
            $table->boolean('document_processing_fee_deduct')->nullable()->default(0);
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
            $table->dropColumn('advance_emi_deduct');
            $table->dropColumn('subvention_deduct');
            $table->dropColumn('document_processing_fee_deduct');
        });
    }
}
