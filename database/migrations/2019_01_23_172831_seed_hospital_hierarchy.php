<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Hospital;

class SeedHospitalHierarchy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $hospitals = Hospital::all()->sortBy('id');
        $lft=1; $rgt=2;     
        foreach ($hospitals as $hospital) {
          $hospital->parent_id = null;
          $hospital->lft=$lft;
          $hospital->rgt=$rgt;
          $hospital->depth=0;
          $hospital->save();
          $lft = $lft+2;
          $rgt = $rgt+2;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
