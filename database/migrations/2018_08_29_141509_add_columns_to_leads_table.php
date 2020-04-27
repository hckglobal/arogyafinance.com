<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE leads CHANGE `location` `location_id` int(10) NULL;');
        DB::statement('ALTER TABLE leads CHANGE `reason` `reject_reason_id` int(10) NULL;');
        DB::statement('ALTER TABLE leads CHANGE `product` `product_id` int(10) NULL;');
        Schema::table('leads', function(Blueprint $table) {
            $table->date('date_of_contact')->nullable();
            $table->string('pin_number')->nullable();
            $table->string('hospital_name')->nullable();
            $table->string('alternate_number')->nullable();
            $table->string('requested_loan_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function(Blueprint $table) {
            $table->dropColumn('date_of_contact');
            $table->dropColumn('pin_number');
            $table->dropColumn('hospital_name');
            $table->dropColumn('alternate_number');
            $table->dropColumn('requested_loan_amount');
             
        });
    }
}
