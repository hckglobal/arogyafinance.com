<?php

namespace App\Http\Controllers\Website\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use App\Application;
use App\Borrower;
use App\Location;


class DashboardController extends Controller
{
  /**
   * [$dashboard_url logged-in user dashboard]
   * @var string
   */
  protected $dashboard_url = "/user/dashboard";

  /**
   * getLogin
   * @param  Request $input 
   * @return [view]
   */
  public function getLogin(Request $input)
  {
    $next_url = $input->get('next');
    
      if ($next_url) {
        $title = "Please enter your Arogya Card Number/Reference Code to continue";
      } else {
        $title = "Please enter your Reference Code to continue";
      }
      
      if (Session::has('borrower_id')) {
        return redirect($this->dashboard_url);
      }
      
    return view('website.pages.dashboard.login')->with(['title'=>$title, 'locale'=>'en']);
    }

    /**
     * [postLogin check the reference code exist or not if not redirect to login page]
     * @param  Request $input 
     * @return [view]
     */
    public function postLogin(Request $input)
    {
      $ref=$input->get('reference_code');
      //check if next is emtpy
      $next_url = $input->get('next') =="" ? $this->dashboard_url : $input->get('next');
      $application= Application::where('reference_code',$ref)->orWhere('card_no',$ref)->first();

      if ($application!=null) {
        Session::put('borrower_id',$application->borrower->id);
        Session::put('login','UserLoggedIn');
        return $next_url;
      } else {
        return response('Unauthorized.', 401);
      }

    }

    /**
     * [logout redirect to home page]
     * @return home page
     */
    public function logout()
    {
      Session::forget('borrower_id');
      Session::forget('login');
      Session::forget('top_up');
      //redirect to home
      return redirect('/');
    }

    /**
     * [userDashboard view dashboard]
     * @return [view]
     */
    public function userDashboard(Request $input)
    {
   	
      if (Session::has('borrower_id')) {

        $borrower = Borrower::find(Session::get('borrower_id'));
        $application = $borrower->application;
        if ($input->has('status')){
          $mandate = $application->mandate;
          $mandate->status=$input->status;
          $mandate->message=$input->message;
          $mandate->save();
        }
        $logs = $application->logs->where('field','status');
        $amount=$application->type=="card" ? 1000 :1180;
        
        return view('website.pages.dashboard.dashboard')
              ->with(['borrower'=>$borrower, 'application'=>$application, 'logs'=>$logs, 'amount'=>$amount,'locale'=>'en']);
      }
      return redirect('login');
    }

    /**
     * [userDocuments view to upload document]
     * @return [view]
     */
    public function userDocuments()
    {
      if (Session::has('borrower_id')) {
        $borrower = Borrower::find(Session::get('borrower_id'));
        $application = $borrower->application;
        return view('website.pages.dashboard.document')->with(['borrower'=>$borrower,'application'=>$application,'locale'=>'en']);
      }
      return redirect('login');
    }

    /**
     * [applyForLoan allow the card application to apply loan against card]
     * @return [view] 
     */
    public function applyForLoan() 
    {
      if (Session::has('borrower_id')) {
        $borrower = Borrower::find(Session::get('borrower_id'));
        $application = $borrower->application;
        $locations = Location::all();
        return view('website.pages.dashboard.apply_for_loan')
              ->with(['locations'=>$locations,'borrower'=>$borrower,'application'=>$application,'locale'=>'en']);
      }
      return redirect('login');
    }

    /**
     * userPaymentStatus
     * @return [view]
     */
    public function userPaymentStatus()
    {
      if (Session::has('borrower_id')) {
        $borrower = Borrower::find(Session::get('borrower_id'));
        $application = $borrower->application;
        $logs = $application->logs->where('field','status');
        $amount=$application->type=="card" ? 1000 :1180;
        return view('website.pages.dashboard.dashboard')
              ->with(['borrower'=>$borrower, 'application'=>$application, 'logs'=>$logs, 'amount'=>$amount,'locale'=>'en']);
      }
      return redirect('login');
    }

    public function chooseTopup()
    {
      return view('website.pages.dashboard.choose_top_up')->with(['locale'=>'en']);
    }
    /**
     * [applyForTopup allow the user applicant to apply for topup loan applications]
     * @return [view] 
     */
    public function applyForTopup($type) 
    {
      if (Session::has('borrower_id')) {
        $borrower = Borrower::find(Session::get('borrower_id'));
        
        $application = $borrower->application;
        Session::put('top_up',$application->reference_code);
        return redirect('apply/'.$type.'/personal-details');
        //dd($application);
        /*$locations = Location::all();
        return view('website.pages.dashboard.apply_for_loan')
              ->with(['locations'=>$locations,'borrower'=>$borrower,'application'=>$application,'locale'=>'en']);*/
      }
      
    }
}
