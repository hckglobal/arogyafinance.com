<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\OutstandingPrincipalReport;
use App\Http\Controllers\Admin\Application\RepaymentController;
use App\Application;
use App\Http\Controllers\Admin\Application\CollectionController;
use Carbon\Carbon;

class UpdateAccountRepaymentSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateAccountRepaymentSchedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description ='Update Account Repayment Schedules for disbursed & closed cases';

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
        $total_applications = Application::where('type','loan')
            ->whereIN('status',['disbursed','closed']);
        $count_applications = $total_applications->count();
        //dd($count_applications);
        $bar = $this->output->createProgressBar($count_applications);
        $collection_obj = new CollectionController;
        $repayment_object = new RepaymentController();
        $overdue_month = Carbon::now()->format('Y-m');
        $applications_chunks = $total_applications->chunk(100, function ($applications) 
            use ($bar,$collection_obj,$repayment_object,$overdue_month)
            {
                foreach ($applications as $application) {
                    if($application->accountRepaymentSchedule()->count()>0) {
                        if($application->collections->count()) {
                            $collection_obj->updateAccountRepaymentCollectionDetail($application);
                            //$repayment_object->getOverdueAndDPD($application, $overdue_month);
                            $bar->advance();
                        }
                    }                
                }
            });
        $bar->finish();
    }
}