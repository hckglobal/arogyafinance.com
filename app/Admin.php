<?php
namespace App;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Carbon\Carbon;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Borrower;


class Admin extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;
	use EntrustUserTrait;

	protected $fillable = ['first_name' , 'last_name' , 'email' , 'password',
        'referrer_code', 'application_column', 'application_column_value',
        'merchant_api_token', 'mobile_number','email_notification','status','api_token'];

    protected $hidden = ['password', 'remember_token'];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function roles(){
        return $this->belongsToMany('App\Role');
    }


    public function states()
    {
        return $this->belongsToMany('App\State');
    }

    public function cities()
    {
        return $this->belongsToMany('App\City');
    }

    public function applications()
    {
        if($this->hasRole(['admin','supervisor','cibil-supervisor','operations'])){
          //get all applications
          return new Application;
        } elseif ($this->hasRole(['credit-manager'])){
            //get the verified applications
             return new Application;
        } elseif($this->hasRole(['ms-supervisor'])){            
            return Application::whereIn('treatment_type',['Multiple Sclerosis','MS','M.S.','M S','M.S','MS.']);
        } elseif($this->hasRole(['partner','affiliate','finance-partner'])){
            //get Partner Reference code
            $partner_reference_code = $this->referrer_code;
            $field = $this->application_column;
            $values = $this->application_column_value;
            $pieces = explode(",",$values);
            //dd($pieces);
            if($field =="hospital_name") {
            $data_collection = collect();
                foreach ($pieces as $key=>$piece) {
                    //$data=array();
                    $hospital = Hospital::where('name',$piece)->first();
                    if($hospital){
                        if($hospital->isRoot()){
                            $hospital_childrens = $hospital->getDescendantsAndSelf();
                            foreach ($hospital_childrens as $children) {
                                $data_collection->push($children->name);
                            }                            
                      } elseif(!$hospital->isRoot()) {
                            $hospital_childrens = $hospital->getDescendantsAndSelf();
                            foreach ($hospital_childrens as $children) {
                                $data_collection->push($children->name);
                            }
                        }
                    }
                }
                return Application::where(function($query) use ($partner_reference_code, $field, $data_collection){
                            return $query->where('partner_reference_code', $partner_reference_code)
                                         ->orwhereIn($field,$data_collection->toArray());
                        });
            } elseif($field !="none" && $field !="hospital_name"){
                return Application::whereIn($field,$pieces);
            } else {
                return Application::where('partner_reference_code',$partner_reference_code);
            }        
        } elseif($this->hasRole(['counsellor','sales-representative'])){
          //get location
          $locations = $this->locations->pluck('id');            
          $applications = Application::whereIn('location_id',$locations);          
          //get all applications
          return $applications;
        }
    }

    public function getApplicationsAttribute()
    {
        return $this->applications()->get();
    }

    public function leads()
    {
        if($this->hasRole(['admin','supervisor','cibil-supervisor','operations','credit-manager','ms-supervisor'])){
          return new Lead;
        } elseif($this->hasRole(['counsellor','sales-representative'])){
          $locations = $this->locations->pluck('id');            
          $leads = Lead::whereIn('location_id',$locations);          
          return $leads;
        } elseif($this->hasRole(['partner'])){
            $partner_reference_code = $this->referrer_code;            
            return Lead::where('referrer_id',$partner_reference_code);
        }
    }

    public function getLeadsAttribute()
    {
        return $this->leads()->get();
    }

    /**
     * Get the log for the admin
     */
    public function logs()
    {
        return $this->hasMany('App\Log');
    }

    /**
     * Get the Location for the admin
     */
    public function locations()
    {
        return $this->belongsToMany('App\Location', 'admin_location');
    }

    /**
     * Get the turn around time for new applications
     */
    public function getTAT($status)
    {
        if($this->applications()) {
            $applications = $this->applications()->get();
            //dd($applications->count());
            $application_logs=collect();
            if ($applications != null) {
                foreach ($applications as $application) {
                    //dd($application);
                    if($application->logs() != null){
                        //dd($application->logs()->count());
                        $logs=$application->logs()->where('old_value',$status)->orderBy('created_at','asc')->get();
                        $old_val=$logs->pluck('old_value');
                        $last_val="";                        
                        foreach ($logs as $log) {
                            $data = array();
                            if ($old_val)  $log->tat=Carbon::parse($application->getOriginal('created_at'))->diffInHours(Carbon::parse($log->getOriginal('created_at')), true);

                            if ($last_val) $log->tat = Carbon::parse($log->getOriginal('created_at'))->diffInHours($last_val, true);

                            $last_val = Carbon::parse($log->getOriginal('created_at'));
                            array_push($data,$log->id);
                            array_push($data,$log->application_id);
                            if (isset($log->admin->first_name)) {
                                array_push($data,$log->admin->first_name.' '.$log->admin->last_name);
                            } else {
                                array_push($data,'Admin name not available');
                            }                                                        
                            array_push($data,$log->old_value);
                            array_push($data,$log->new_value);                         
                            array_push($data,$log->tat);
                            //dd($data);
                            $application_logs->push($data);                                                
                        }
                    }
                }
                return $application_logs;
            }
        }  
    }
}
