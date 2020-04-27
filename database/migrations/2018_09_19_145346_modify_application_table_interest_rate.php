<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyApplicationTableInterestRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `applications` CHANGE `interest_rate` `interest_rate` DECIMAL(8,3) NOT NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `applications` CHANGE `interest_rate` `interest_rate` DECIMAL(8,2) NOT NULL;');
    }
}
