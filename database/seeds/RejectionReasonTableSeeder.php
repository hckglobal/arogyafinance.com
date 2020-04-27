<?php

use Illuminate\Database\Seeder;
use App\RejectionReason;

class RejectionReasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rejection_reasons')->truncate();
        
        RejectionReason::create(["text"=>"Criteria Not met"]);
        RejectionReason::create(["text"=>"Just Enquiry"]);
        RejectionReason::create(["text"=>"Paid In cash"]);
        RejectionReason::create(["text"=>"Rejected"]);
        RejectionReason::create(["text"=>"Used Other brand device"]);
        RejectionReason::create(["text"=>"Not interested in Surgery"]);
        RejectionReason::create(["text"=>"Other"]);
    }
}
