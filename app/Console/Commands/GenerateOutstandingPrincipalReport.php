<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\OutstandingPrincipalReport;
use App\Http\Controllers\Admin\Application\RepaymentController;
use App\Application;

class GenerateOutstandingPrincipalReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GenerateOutstandingPrincipalReport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate outstanding principal report';

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
        $repayment_object = new RepaymentController();
        $repayment_object->generateOutstandingPrincipalReport();                  
    }
}
