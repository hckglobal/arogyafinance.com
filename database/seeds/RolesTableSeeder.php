<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	DB::table('roles')->truncate();

        Role::create(["name"=>"admin","display_name"=>"Admin","description"=>"Administrator"]);
		Role::create(["name"=>"cibil-supervisor","display_name"=>"Cibil Supervisor","description"=>"Cibil Supervisor"]);
		Role::create(["name"=>"counsellor","display_name"=>"Financial Counsellor","description"=>"Financial Counsellor"]);
		Role::create(["name"=>"editor","display_name"=>"Psychometric Test Editor","description"=>"Psychometric Test Editor"]);
		Role::create(["name"=>"credit-manager","display_name"=>"Credit Manager","description"=>"Credit Manager"]);
		Role::create(["name"=>"supervisor","display_name"=>"Supervisor","description"=>"Supervisor"]);
		Role::create(["name"=>"ms-supervisor","display_name"=>"Ms-Supervisor","description"=>"Ms-Supervisoristrator"]);
		Role::create(["name"=>"operations","display_name"=>"Operations","description"=>"Operations"]);
		Role::create(["name"=>"partner","display_name"=>"Partner","description"=>"Partner"]);

    }
}
