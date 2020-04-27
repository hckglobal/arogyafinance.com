<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Admin;
use App\Location;

class CreateAdminLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_location', function (Blueprint $table) {
            $table->integer('admin_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->primary(['admin_id', 'location_id']);
        });

        $admins = Admin::all();
        foreach ($admins as $admin) {
            $location_ids = Location::where('admin_id',$admin->id)->get()->pluck('id');
            if($location_ids->count()){
                $admin->locations()->attach($location_ids->toArray());
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_location');
    }
}
