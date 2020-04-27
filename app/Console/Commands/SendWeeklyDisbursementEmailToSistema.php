<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Mail;
use App\Admin;
use App\Hospital;

class SendWeeklyDisbursementEmailToSistema extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendWeeklyDisbursementEmailToSistema';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send last week disbursed cases count to sistema.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $date = Carbon::now();
        $is_monday = $date->isMonday();
        if($is_monday) {
            $sistema = Admin::where('referrer_code','sistema')->first();
            if(isset($sistema)) {
                // get the current start week as sunday
                $current_start_of_week = Carbon::now()->startOfWeek()->subDay(1)->format('Y-m-d');

                $last_start_of_week = Carbon::now()->previousWeekendDay()->startOfWeek()->format('Y-m-d');
                
                $sistema_hospitals = Hospital::where('hospital_referrer',$sistema->referrer_code)->latest()->get();
                foreach ($sistema_hospitals as $sistema_hospital) {
                    $sistema_disbursed_applications = $sistema->applications()
                        ->where('status','disbursed')
                        ->whereBetween('disbursement_date',[$last_start_of_week,
                        $current_start_of_week])
                        ->where('hospital_name',$sistema_hospital->name)
                        ->count();

                    if($sistema_disbursed_applications>0) {
                        $count = $sistema_disbursed_applications;
                        Mail::send('emails.admin.send_weekly_disbursement_to_sistema', 
                            ['count'=>$count], function ($mail) use ($sistema_hospital)
                            {
                                $mail->to($admin->email, 'Arogya Finance')
                                     ->subject('Loans disbursed during the week');
                        });
                    }
                }
                          
            }
        }
    }
}
