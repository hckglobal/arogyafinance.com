<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Application;
use Mail;
use PDF;
use Image;
use File;
use App\Helpers\Alerts;
use App\Helpers\SMSProvider;

class SendEMISMSPrior extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendEMISMSPrior';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send EMI SMS prior four days of EMI due date to all the borrowers.';

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
        $date = Carbon::now()->format('Y-m-d');
        $today_month = Carbon::now()->format('Y-m');
        $applications_chunks = Application::where('type','loan')->where('status','disbursed')->get()->chunk(100);
        foreach ($applications_chunks as $applications) {
            foreach ($applications as $application) {
                /*if($application->id==2111){*/
                if($application->borrower){    
                    $emi_day = Carbon::parse($application->getOriginal('valid_from'))->format('d');
                    $ideal_repayment_schedules = $application->principalIdealRepaymentSchedule();
                    $current_month_emi = $ideal_repayment_schedules->where('emi_month',$today_month)->first();
                    if ($current_month_emi) {
                        $current_emi_date = $current_month_emi['emi_month']."-".$emi_day;                
                        $emi_notification_date = Carbon::parse($current_emi_date)->subDays(4)->format('Y-m-d');
                        //dd($emi_notification_date,$date);
                        //$diff_in_days = Carbon::parse($current_emi_date)->diffInDays(Carbon::now()->subDays(4));
                        if ($emi_notification_date == $date) {
                            //var_dump($application->id);
                            $message = Alerts::EMINotificationFourDaysPrior($application,Carbon::parse($current_emi_date)->format('d-m-Y'));
                            SMSProvider::send($application->borrower->mobile_number,$message);
                        }                
                    }
                /*}*/
                }    
            }
        }
    }
}
