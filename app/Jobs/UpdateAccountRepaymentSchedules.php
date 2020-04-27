<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Application;
use Illuminate\Bus\Queueable;
use App\Http\Controllers\Admin\Application\CollectionController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Log as DataLog;
use App\Admin;
use Mail;
class UpdateAccountRepaymentSchedules extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs, Queueable;

    protected $ids;
    protected $user;
    protected $collection_name;


    /**
     * UpdateAccountRepaymentSchedules constructor.
     * @param Application $application
     */
    public function __construct($ids,Admin $user,$collection_name)
    {
        $this->ids = $ids;
        $this->user = $user;
        $this->collection_name = $collection_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        //DataLog::info('Inside Handle Function'); 
        $applications = Application::whereIn('id',$this->ids)->get();
        $user_name = $this->user->first_name.' '.$this->user->last_name;
        $email = $this->user->email;
        $collection_name = $this->collection_name;
        $count = $applications->count();
        $obj = new CollectionController();
        foreach ($applications as $application) {
            //DataLog::info('Updateing application-'.$application->id); 
            $obj->updateAccountRepaymentCollectionDetail($application);        
        }

        //DataLog::info('trying to send email notification');

        Mail::send('emails.admin.collection_mail', ['user_name'=>$user_name, 
            'email'=>$email, 'collection_name'=>$collection_name, 'count'=>$count],
            function ($mail) use ($user_name, $email, $collection_name, $count) {
                $mail->to($email)
                    ->subject('Collection update');
        });
        //DataLog::info('email notification sent');
        //DataLog::info('End of Handle Function');         
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed()
    {
        DataLog::info('JOB-failed job');
    }
}