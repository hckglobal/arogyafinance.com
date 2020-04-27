<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\OutstandingPrincipalReport;
use App\Http\Controllers\Admin\Application\RepaymentController;
use App\Application;

class GenerateApplicationstRepaymentSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GenerateApplicationstRepaymentSchedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Account Repayment Schedules for disbursed & closed cases';

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
        $bar = $this->output->createProgressBar($count_applications);
        //dd($count_applications,$total_applications);
        $bar->start();
        $applications_chunks = $total_applications->chunk(100, function ($applications) use ($bar)
            {
                foreach ($applications as $application) {
                    //if(!$application->accountRepaymentSchedule()->count()>0){
                        $application->generateAccountRepaymentSchedules();
                        $bar->advance();
                    //}                
                }
            });
        $bar->finish();
    }
}
