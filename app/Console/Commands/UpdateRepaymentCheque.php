<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\OutstandingPrincipalReport;
use App\Http\Controllers\Admin\Application\RepaymentController;
use App\Application;
use Carbon\Carbon;

class UpdateRepaymentCheque extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateRepaymentCheque';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update repayment cheque date';

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
        $applications_chunks = Application::whereIn('status',['sanctioned','disbursed'])
            ->get(['id','valid_from'])
            ->chunk(100);
        $count=0;
        foreach ($applications_chunks as $applications) {
            foreach ($applications as $application) {
                $valid_from = Carbon::parse($application->getOriginal('valid_from'))->format('Y-m-d');
                $pdcs = $application->repaymentCheques()->where('type','pdc')->get();

                if($pdcs->count()) {
                    $i = 0;
                    
                    foreach ($pdcs as $pdc) {               
                        $pdc->cheque_date=Carbon::parse($application->getOriginal('valid_from'))->addMonthNoOverflow($i);
                        $pdc->save();
                        $i++; 
                    }
                    $count+=1;
                    $this->info('Total Repayment Cheque updated :'.$count);
                }
            }
        }                    
    }
}
