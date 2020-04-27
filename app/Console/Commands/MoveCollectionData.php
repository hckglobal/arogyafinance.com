<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\OutstandingPrincipalReport;
use App\Http\Controllers\Admin\Application\RepaymentController;
use App\OldCollection;
use App\Collection;
use App\Http\Controllers\Admin\Application\CollectionController;

class MoveCollectionData extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MoveCollectionData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move Collection Data';

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
        $old_collection_chunks = OldCollection::/*where('id','>=','14011')->get()*/all()->chunk(100);
        foreach ($old_collection_chunks as $old_collections) {
            foreach ($old_collections as $old_collection) {
                if($old_collection->application) {
                    /*if($old_collection->application->accountRepaymentSchedule()->count()>0){*/
                        $data['application_id']=$old_collection->application_id;
                        $data['emi_payment_date']=$old_collection->emi_payment_date;
                        $data['amount_received']=$old_collection->amount_received;
                        $data['narration']=$old_collection->narration;
                        $data['ref_no']=$old_collection->ref_no;
                        $data['source']=$old_collection->source;
                        $data['created_at']=$old_collection->created_at;
                        $data['updated_at']=$old_collection->updated_at;
                        $data['type']='emi';
                        //dd($data);                
                        $collection = Collection::create($data);
                        /*$collection_obj = new CollectionController;
                        $collection_obj->updateAccountRepaymentCollectionDetail($application)
                        $collection_obj->updateAccountRepaymentDetail($collection->id);*/
                        //dd('collection added');
                    /*} */                   
                }                
            }
        }
        return "Collection moved!";      
    }
}
