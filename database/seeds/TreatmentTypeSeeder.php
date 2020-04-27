<?php

use Illuminate\Database\Seeder;
use App\TreatmentType;

class TreatmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      //reset table   
      TreatmentType::truncate();

      $treatments = 
      [
	        ["name"=>"Bariatric"],
			["name"=>"Bone & Joints (Orthopedics)"],
			["name"=>"Cancer (Oncology)"],
			["name"=>"Cardio Vascular (Angioplasty)"],
			["name"=>"Cardiology (Heart Valves/Surgery)"],
			["name"=>"CRDM (Pace Makers)"],
			["name"=>"Dental"],
			["name"=>"Diabetology"],
			["name"=>"ENT"],
			["name"=>"Gastrointestinal"],
			["name"=>"General Surgery"],
			["name"=>"Hair Transplant"],
			["name"=>"IVF"],
			["name"=>"Neurology & Neuro Surgery"],
			["name"=>"Obstetrics & Gynaecology"],
			["name"=>"Ophthalmology (Eye Related)"],
			["name"=>"Pediatrics"],
			["name"=>"Physiotherapy"],
			["name"=>"Plastic Surgery"],
			["name"=>"Psychotherapy"],
			["name"=>"Radiology"],
			["name"=>"Rheumatology"],
			["name"=>"Skin Related (Dermatology)"],
			["name"=>"Spine"],
			["name"=>"Trauma & Critical Care (Accident)"],
			["name"=>"Urology"],
			["name"=>"Others"]
	];
        
        
        TreatmentType::insert($treatments);
        
		
    }
}
