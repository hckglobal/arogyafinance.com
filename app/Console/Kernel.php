<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\SendBirthdayEmails::class,
        \App\Console\Commands\SendEMISMSPrior::class,
        \App\Console\Commands\SendWeeklyDisbursementEmailToSistema::class,
        \App\Console\Commands\GenerateApplicationstRepaymentSchedules::class,
        \App\Console\Commands\GenerateOutstandingPrincipalReport::class,
        \App\Console\Commands\MoveCollectionData::class,
        \App\Console\Commands\UpdateAccountRepaymentSchedules::class,
        \App\Console\Commands\DataDump::class,
        \App\Console\Commands\CibilDataDump::class,
        \App\Console\Commands\UpdateRepaymentCheque::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
        $schedule->command('SendBirthdayEmails')->dailyAt('8:00');
        //$schedule->command('generateOutstandingReport');
        $schedule->command('SendEMISMSPrior')->dailyAt('9:00');
        $schedule->command('SendWeeklyDisbursementEmailToSistema')->weekly()->mondays()->at('11:00');
        /*$schedule->command('DataDump')->when(function () {
                return Carbon\Carbon::now()->startOfMonth()->addDays(2)->isToday();
            })->at('00:01');*/
        /*$schedule->command('CibilDataDump')->when(function () {
                return Carbon\Carbon::now()->startOfMonth()->addDays(2)->isToday();
            })->at('07:00');*/
    }
}
