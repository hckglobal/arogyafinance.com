<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Form;
use Carbon;
use PDF;
use App\Admin;
use App\Question;
use App\Answer;
use DB;
use App\Role;
use App\Location;
use Session;
use Redirect;
use App\Borrower;

class AdminController extends Controller
{
    /**
     * Show Admin Dashboard for card to the user.
     *
     * @return
     */

    public function login()
    {
        return view('admin.pages.login');
    }


    /**
     * Show all the card applications
     *
     * @return
     */

    public function applicationsCard($category)
    {
        switch ($category) {

            case 'one':
                $forms = Form::card()->categoryOne()->get();
                break;

            case 'two':
                $forms = Form::card()->categoryTwo()->get();
                break;

            case 'three':
                $forms = Form::card()->categoryThree()->get();
                break;

            case 'four':
                $forms = Form::card()->categoryFour()->get();
                break;

            case 'none':
                $forms = Form::card()->categoryNone()->get();
                break;
            default:
               break;

        }
        $title = "Card Applications ";

        return view('admin.pages.card.index')->with(['title'=>$title,'forms'=>$forms,'category'=>$category]);
    }

    /**
     * Show all the loan applications
     *
     * @return
     */

    public function applicationsLoan($category)
    {
    	switch ($category) {

            case 'one':
                $forms = Form::loan()->categoryOne()->get();
                break;

            case 'two':
                $forms = Form::loan()->categoryTwo()->get();

                break;

            case 'three':

                $forms = Form::loan()->categoryThree()->get();

                break;

            case 'four':

                $forms = Form::loan()->categoryFour()->get();

                break;

            case 'none':

                $forms = Form::loan()->categoryNone()->get();

                break;

            default:

                break;
        }
        $title = " Loan Applications";
    	return view('admin.pages.loan.index')->with(['title'=>$title,'forms'=>$forms,'category'=>$category]);
    }



    /**
     * Show application info
     *
     * @return
     */

    public function showApplicationLoan($id)
    {
        $title = "Loan Application";
    	$form = Form::find($id);
    	return view('admin.pages.loan.show')->with(['title'=>$title,'form'=>$form]);
    }
    /**
     * Shows Application-Info.
     *
     * @return
     */

    public function showApplicationCard($id)
    {
        $title = "Card Application";
        $form = Form::find($id);
        return view('admin.pages.card.show')->with(['title'=>$title,'form'=>$form]);
    }

    public function note(Request $input)
    {

    }



    /**
     * Returns Pdf Format File Of Application.
     *
     * @return
     */

    public function applicationPdfCard($id)
    {
        $user = User::find($id);

        $date = Carbon\Carbon::now();

        $data = ['date'=>$date, 'user'=>$user];

        $pdf = PDF::loadView('pages.pdfcard', $data)->setPaper('a4');

        return $pdf->download('card.pdf');
    }



    /**
     * Returns Pdf Format File Of Application.
     *
     * @return
     */

    public function applicationPdfLoan($id)
    {
        $user = Form::find($id)->user;

        $date = Carbon\Carbon::now();

        $data = ['date'=>$date, 'user'=>$user];

        $pdf = PDF::loadView('pages.pdfloan', $data)->setPaper('a4');

        return $pdf->download('loan.pdf');
    }

    public function testIndex()
    {
      $title = "Test Result";
      $answers = Answer::all();
      return view('admin.pages.test-index')->with(['answers'=>$answers,'title'=>$title]);
    }

    


    /**
     * Approves the input of new password for user.
     *
     * @return
     */

    public function changePassword()
    {
        return view('admin.pages.change-password');
    }

    /**
     * Approves the input of new password for user.
     *
     * @return
     */

    public function createPassword()
    {

    }


    public function show()
    {
          $title = "All Staff";
          $admins = Admin::all();
          return view('admin.pages.staff.index')->with(['title'=>$title,'admins'=>$admins]);
    }

    public function store(Request $input)
    {
      $admin = Admin::create($input->all());
      if($input->has('locations')){
          $admin->locations()->sync($input->get('locations'));
      }
      $admin->roles()->sync($input->get('role_id'));
      Session::flash('info','Staff created');
      return redirect('/admin/staff/all');
    }



    public function create()
    {
          $title = "Add Staff";
          $states = States::all();
          $cities = City::all();
          $roles = Role::where('name','!=','admin')->get();
          return view('admin.pages.staff.create')->with(['title'=>$title,'states'=>$states,'cities'=>$cities,'roles'=>$roles]);
    }

    public function edit($id)
    {
          $title = "Edit Staff";
          $states = States::all();
          $cities = City::all();
          $roles = Role::where('name','!=','admin')->get();
          $admin = Admin::find($id);
          return view('admin.pages.staff.edit')->with(['title'=>$title,'admin'=>$admin,'states'=>$states,'cities'=>$cities,'roles'=>$roles]);
    }


    public function update($id, Request $input)
    {
      $admin = Admin::find($id);
      $admin->update($input->all());
      if($input->has('locations')){

      $admin->locations()->sync($input->get('locations'));
      }
      $admin->roles()->sync($input->get('role_id'));
      Session::flash('info','Staff updated');
      return redirect('/admin/staff/all');
    }

     public function destroy($id)
    {
      Admin::destroy($id);
      Session::flash('info','Staff deleted');
      return Redirect::back();
    }





}
