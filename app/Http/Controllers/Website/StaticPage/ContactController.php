<?php

namespace App\Http\Controllers\Website\StaticPage;

use Illuminate\Http\Request;
use Mail;
use App\User;
use App\Level;
use Session;
use App\State;
use App\Question;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect; 

class ContactController extends Controller
{
	/**
     * Define your validation rules in a property in 
     * the controller to reuse the rules.
     */
    protected $validationRules=[
        'g-recaptcha-response' => 'required|captcha',
        'first_name' => 'required',
        'last_name' => 'required',
        'phone' => 'required',
        'email_id' => 'required',
        'loan_type' => 'required',
        'subject' => 'required',
        'message' => 'required',
        'location' => 'required'
    ];

	/**
	 * Show home page to the user.
	 *
	 * @return 
	 */
	public function getContact()
	{	
		return view('website.pages.static_pages.contact')->with(['locale'=>'en']);
	}
	
	/**
	 * Show email send by the user.
	 *
	 * @return 
	 */
	public function postContact(Request $input)
	{
		$validator = Validator::make($input->all(), $this->validationRules);
        if($validator->fails()) {
		    return Redirect::back()->withErrors($validator);
		}
		$firstname = $input->get('first_name');
		$lastname = $input->get('last_name');
		$phone = $input->get('phone');
		$email = $input->get('email_id');
		$loanType = $input->get('loan_type');
		$subject = $input->get('subject');
		$contactMessage = $input->get('message');
		$location = $input->get('location');


		if($input->get('loan_type')=="General Inquiry" || $input->get('loan_type')=="Medical Loan" ){

			Mail::send('emails.contact', ['firstname'=>$firstname,
			                           'lastname'=>$lastname,
			                           'phone'=>$phone,
			                           'email'=>$email,
			                           'loanType'=>$loanType,
			                           'subject'=>$subject,
			                           'contactMessage'=>$contactMessage,
			                           'location'=>$location],
			                            function($mail){
                                                $mail->to('info@arogyafinance.com', 'Arogya Finance')
                                                ->to('manglesh.pal@arogyafinance.com', 'Arogya Finance')
                                                 ->subject('New General Inquiry/ Medical Loan Inquiry from arogyafinance.com');
                                            });

		}else{


			Mail::send('emails.contact', ['firstname'=>$firstname,
			                           'lastname'=>$lastname,
			                           'phone'=>$phone,
			                           'email'=>$email,
			                           'loanType'=>$loanType,
			                           'subject'=>$subject,
			                           'contactMessage'=>$contactMessage,
			                           'location'=>$location],
			                            function($mail){
                                                $mail->to('jpeter@arogyafinance.com', 'Arogya Finance')
                                                ->to('manglesh.pal@arogyafinance.com', 'Arogya Finance')
                                                 ->subject('New Associate/Partner Request from arogyafinance.com');
                                            });

		}


		
		Session::flash('info', 'Thank you for contacting us. We will get back to you soon.');
		return redirect('contact');
	}
   
	/**
	 * Show the career form
	 *
	 * @return 
	 */
	public function getCareers()
	{
		$states=  State::all();
		return view ('website.pages.static_pages.careers')->with(['states'=>$states,'locale'=>'en']);
	}

	/**
	 * process the career form
	 *
	 * @return 
	 */

	public function postCareers(Request $input)
	{
		$destinationPath = public_path().'/uploads/resumes';
		$filePath="";

		 if($input->hasFile('resume')){
		 	 $file= $input->file('resume');
             $filePath = $destinationPath.'/'.$file->getClientOriginalName();
		 	 $file->move($destinationPath, $file->getClientOriginalName());
		 }
		
		Mail::send('emails.careers', ['data'=>$input->all()],
			                           function($mail) use ($filePath){
                                                $mail->to('info@arogyafinance.com', 'Arogya Finance')
                                                 ->subject('New Career Application From Arogyafinance.com')
                                                 ->attach($filePath, ['as' => 'Resume']);
                                         });
		Session::flash('info', 'Thank you for contacting us. We will get back to you soon.');
		return Redirect::back();
	}
}
