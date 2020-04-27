<?php
namespace App\Http\Controllers\Admin\DMI;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Auth;
use App\Admin;
use App\Role;
use Redirect;
use Session;
use App\Application;
use App\Document;
use Carbon\Carbon;
use Log;
use Storage;
use File;
class PartnerController extends Controller
{
	protected $api_token="6W6eRvjl9s1epvcClnzb";

	/**
	 * My application 
	 * @return \Illuminate\Http\Response
	 */
	public function myapplication()
	{
		$title = "All Application";
		$applications = Application::all();
		return view('admin.pages.partner.myapplication')->with(['title'=>$title,'applications'=>$applications]);
	}

	/**
	 * Send this application to DMI
	 * @param  [int]  $id   Application ID 
	 * @return \Illuminate\Http\Response         
	 */
	public function sendToDmi($id)
	{
		$application = Application::find($id);
		//return $application->advance_emi;
		$connection = $this->connectionToDMIServer();
		$authentication = $connection['authentication'];
		$instance_url = $connection['instance_url'];
		$lead = $this->initiate($application, $authentication, $instance_url);
		
		Session::flash('info','DMI Sent');
      	return redirect()->back();	
	}

	/**
	 * Connect to DMI Server 
	 * @return application                 
	 */
	public function connectionToDMIServer()
	{
		$client1 = new \GuzzleHttp\Client();
		$auth_url="https://login.salesforce.com/services/oauth2/token?grant_type=password&client_id=3MVG9Y6d_Btp4xp48T8hKwfkR26ReTi9WHjs1.FCvXnrYNAP2YKqpIobzTDZz9ebfBJG.vKqR4klTAlaZWYz6&client_secret=5625405095383100305&username=arogya@dmifinance.in&password=Dmi@aro123IT7btx8yw57Sy5UldZsSHYTdh";
		// Create a request with auth credentials
		$auth_url_request = $client1->request('POST',$auth_url);
		// Get the actual response without headers
		//$response = $request->getBody();
		$auth_url_response =json_decode($auth_url_request->getBody(), true);
		//return $response;
		$access_token= $auth_url_response['access_token'];
		$instance_url=$auth_url_response['instance_url'];
		$authentication = new \GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json',
														'Authorization'=> 'OAuth '.$access_token
														]
										]);
		return ['instance_url'=>$instance_url,'authentication'=>$authentication];
	}

	/**
	 * Initiate Lead for a this application
	 * @param  [property] $lead    
	 * @param  [property] $authentication         
	 * @param  [property] $instance_url   
	 * @return application                 
	 */
	public function initiate($application,$authentication, $instance_url)
	{
		
		$doc_urls = $this->sendDocumentToDMI($application);
		
		$lead = $this->leadCreation($application, $authentication, $instance_url, $doc_urls);
		
		Log::info('lead = '.$lead);
		foreach ($application->borrowers as $borrower) {
			$contact = $this->contactCreation($borrower, $authentication, $lead, $instance_url, $doc_urls);
			Log::info('contact = '.$contact);
			if ($borrower->type=='Primary') {
				$multibureau = $this->multiBureau($application,$contact, $authentication, $instance_url);
				Log::info('multibureau = '.$multibureau);
			}
		}
		if (!$application->self_patient) {
			$patient_contact = $this->patientContactCreation($application, $authentication, $lead, 
								$instance_url);
			Log::info('patient_contact = '.$patient_contact);
		}
		//$conversion = $this->updateLead($lead,$authentication, $instance_url);
		//Log::info('conversion reply = '.$conversion);
		//dd($conversion);
		$application->dmi_status='lead';
		$application->dmi_sent=0;
		$date = Carbon::now();
		$application->dmi_issue_date=$date;
		$application->lead_id=$lead;
		$application->save();
	}

	/**
	 * Lead Creation for a single application
	 * @param  [object] $application    
	 * @param  [property] $authentication         
	 * @param  [property] $instance_url   
	 * @return Lead ID                 
	 */
	public function leadCreation($application, $authentication, $instance_url, $doc_urls)
	{
		/* Lead Creation */
		$lead['Actual_Medical_Bill__c']=$application->estimated_cost;		
		$lead['FirstName']=$application->borrower->first_name;	
		$lead['MiddleName']=$application->borrower->middle_name;		
		$lead['LastName']=$application->borrower->last_name;
		$borrower_profession=$application->borrower->nature_of_income;
		
		if ($borrower_profession == "Salaried/Wages") {
			$lead['Sector__c']="Salaried";
		} elseif ($borrower_profession == "Self employed") {
			$lead['Sector__c']="SENP";
		} else {
			$lead['Sector__c']="Others";
		}
		$lead['Loan_Rate__c']=$application->effective_interest_rate;
		$lead['Email']=$application->borrower->email;
		$lead['Industry']="HealthCare";
		$lead['Business_Type__c']="Health Care Loan";
		$lead['RecordType_List__c']="Retail Borrower Account";
		$lead['Type_of_Treatment__c']=$application->treatment_type;
		$lead['LeadSource_S__c']="a0d9000000AOtZ5";
		$lead['Application_Id__c']=$application->pin_number;
		$lead['Expected_Disbursement_Date__c']=$application->disbursement_date;
		$lead['Application_Creation_Date__c']= Carbon::parse($application->getOriginal('created_at'))
												->format('Y-m-d');		
		$lead['Amount_in_Rs__c']=$application->approved_loan_amount;
		$lead['Loan_Tenor_in_Month__c']=$application->approved_loan_tenure;
		$lead['DOB__c']=$application->borrower->date_of_birth;
		$lead['Gender__c']=$application->borrower->gender;
		$lead['Collateral_Type__c']="Non-Secure";
		$lead['Security_del__c']="NA";
		$lead['Hospital_Name__c']=$application->hospital_name;
		$lead['Loan_to_be_Disbursed__c']=$application->hospital_name;
		$lead['Net_Salary_Monthly__c']=$application->borrower->borrowers_income;
		$lead['Proposed_EMI__c']=$application->approved_loan_emi;
		$lead['Eligible_Loan_Amount_INR__c']=$application->approved_loan_amount;
		$lead['Existing_EMI__c']=$application->borrower->current_loan_emi;
		$lead['Down_Payment__c']=$application->advance_emi * $application->approved_loan_emi;
		$lead['Advance_EMI__c']=$application->advance_emi * $application->approved_loan_emi;
		$lead['Aadhaar_Number__c']=$application->borrower->aadhar_card_number;

		$lead['PAN__c']=$application->borrower->pan_card_number;
		$lead['Company_Name__c']=$application->borrower->name_of_firm;
		$lead['Loan_Purpose__c']=$application->treatment_type;
		$string = "";
		foreach($application->notes as $key=>$note) {
			$string.="Note_".$key."=".$note->text.' ,';
		}
		$lead['Personal_Discussions_Comments__c']=$string;
		$lead['No_of_Advanced_EMI_s__c']=$application->advance_emi;
		$lead['First_Coupon_Date__c']=Carbon::parse($application->getOriginal('valid_from'))
												->format('Y-m-d');
		
		if($application->borrower->earning_since) {
			$earning_since = Carbon::createFromDate($application->borrower->earning_since);
			$today = Carbon::today();
			$diff_years = $today->diffInYears($earning_since);
			$lead['Office_Stability_in_Months__c']=$diff_years*12;
		}
		
		$residing_since = Carbon::createFromDate($application->borrower->residing_since);
		$today = Carbon::today();
		$residing_since_years = $today->diffInYears($residing_since);
		$lead['Residence_Stability_in_Months__c']=$residing_since_years*12;
		$lead['FOIR__c']=$application->foir;										
		$lead['Street']=$application->borrower->address_line_1.' '.$application->borrower->address_line_2;
		$lead['City']=$application->borrower->city;
		$lead['State']=$application->borrower->state;
		$lead['PostalCode']=$application->borrower->pincode;
		$lead['Country']="India";
		$lead['Phone']=$application->borrower->mobile_number;

		$lead['Disbursal_Bank_Name__c']=$application->bank_name;
		$lead['Beneficiary_Name__c']=$application->bank_customer_name;
		$lead['Beneficiary_Acc_No__c']=$application->bank_account_number;
		
		$lead['Subvention__c']=($application->approved_loan_amount * $application->subvention)/100;
		$lead['Collateral_Offered__c']="NA";
		$lead['Hospital_Location__c']=$application->location->name;
		if ($application->borrower->id_proof_type=="Voter ID") {
			$lead['Voter_Id__c']=$application->borrower->id_proof_number;
		} else {
			$lead['Voter_Id__c']="NA";
		}
		//$lead['Ready_for_Conversion__c']="Yes";
		$lead['Ready_for_Decision__c']="Yes";
		$lead['Application_URL__c']="NA";
		//dd($doc_urls);
		if(isset($doc_urls['Address-proof'])){
			$lead['Address_Document_URL__c']=$doc_urls['Address-proof'];
		} else {
			$lead['Address_Document_URL__c']="NA";
		}
		if(isset($doc_urls['Income-proof'])){
			$lead['Salary_Slip_URL__c']=$doc_urls['Income-proof'];
		} else {
			$lead['Salary_Slip_URL__c']="NA";
		}
		if(isset($doc_urls['Bank-statement'])){
			$lead['Bank_Statement_URL__c']=$doc_urls['Bank-statement'];
		} else {
			$lead['Bank_Statement_URL__c']="NA";
		}
		if(isset($doc_urls['Photo'])){
			$lead['Borrower_Photo_URL__c']=$doc_urls['Photo'];
		} else {
			$lead['Borrower_Photo_URL__c']="NA";
		}
		if(isset($doc_urls['Id-proof'])){
			$lead['ID_Document_URL__c']=$doc_urls['Id-proof'];
		} else {
			$lead['ID_Document_URL__c']="NA";
		}
		if(isset($doc_urls['Disbursement-documents'])) {
			$lead['Other_Document_URL__c']=$doc_urls['Disbursement-documents'];			
		} else {
			$lead['Other_Document_URL__c']="NA";
		}		
		/* End of Lead Creation */
		$lead=json_encode($lead);
		Log::info('lead='.$lead);
		//dd($lead);	
		$lead_url = $instance_url."/services/data/v39.0/sobjects/lead";
		// Create a request with auth credentials
		$lead_url_response = $authentication->request('POST',$lead_url,['body'=>$lead]);
		// Get the actual response without headers
		//$lead_response = $lead_url_response->getBody();
		$lead_response =json_decode($lead_url_response->getBody(), true);
		
		$lead_id= $lead_response['id'];
		return $lead_id;
	}

	/**
	 * Patient Contact Creation for a single application
	 * @param  [object] $application    
	 * @param  [property] $authentication 
	 * @param  [property] $lead           
	 * @param  [array] $instance_url   
	 * @return Contact ID                
	 */
	public function patientContactCreation($application, $authentication, $lead, $instance_url)
	{		
		/* Patient Contact Creation */
		$contact['FirstName']=$application->patient->first_name;	
		$contact['MiddleName']=$application->patient->middle_name;		
		$contact['LastName']=$application->patient->last_name;
		$contact['Lead__c']=$lead;
		$contact['Sector__c']="NA";
		switch ($application->borrower->residence_type) {
			case 'Owned - 1 BHK':
			case 'Owned - 2 BHK':
			case 'Owned - 3 BHK':
				$contact['Residence_Type__c']="Owned";
				$contact['Home_Owner__c']="Owned";
				break;
			case 'Rented - 1 BHK':
			case 'Rented - 2 BHK':
			case 'Rented - 3 BHK':
			case 'Company Provided':
				$contact['Residence_Type__c']="Rented";
				$contact['Home_Owner__c']="Rented";
				$contact['OtherStreet']=$application->patient->permanent_address;
				$contact['OtherCity']=$application->patient->permanent_city;
				$contact['OtherState']=$application->patient->permanent_state;
				$contact['OtherPostalCode']=$application->patient->permanent_pincode;				
				$contact['OtherCountry']="India";				
				break;
			default:
				$contact['Residence_Type__c']="Parental";
				$contact['Home_Owner__c']="Parental";
				break;
		}
		$contact['Address_Category__c']="Residential";
		$contact['MailingStreet']=$application->patient->address_line_1.' '.$application->patient->address_line_2;
		$contact['MailingCity']=$application->patient->city;
		$contact['MailingState']=$application->patient->state;
		$contact['MailingPostalCode']=$application->patient->pincode;
		$contact['MailingCountry']="India";
		
		$contact['Phone']=$application->patient->mobile_number;
		$contact['Nationality__c']="Indian";
		$contact['Gender__c']=$application->patient->gender;
		$contact['Birthdate']=$application->patient->date_of_birth;
		$contact['Email']=$application->patient->email;
		$contact['Borrower_Type__c']="Patient";
		$contact['Father_Name__c']=$application->patient->middle_name;
		//$contact['Relation_with_the_Patient__c']="Self";
		$contact['Marital_Status__c']=$application->patient->marital_status;
		$contact['Since_Residing_on_the_Current_Address__c']=$application->patient->residing_since;
		$contact['Aadhaar_Number__c']=$application->patient->aadhar_card;
		$contact['PAN_ID__c']=$application->patient->pan_card;
		$contact['Monthly_Income__c']="";
		$contact['Psychometric_Result__c']="NA";
		$contact['Name_of_Firm_Company_Establishment_In__c']="NA";
		$contact['Mode_of_Loan_Repayment__c']=$application->mode_of_payment;
		//$contact['CIBIL_Score__c']=$application->cibil_score;
		$contact['KYC_Documents__c']="true";
		
		/* End of patient contact Creation */
		$contact=json_encode($contact);
		Log::info('patient contact='.$contact);
		$contact_url = $instance_url."/services/data/v39.0/sobjects/contact";
		// Create a request with auth credentials
		$contact_url_response = $authentication->request('POST',$contact_url,['body'=>$contact]);
		// Get the actual response without headers
		//$contact_response = $contact_url_response->getBody();
		$contact_response =json_decode($contact_url_response->getBody(), true);
		$contact_id= $contact_response['id'];
		return $contact_id;
	}

	/**
	 * Contact Creation for a single borrower
	 * @param  [object] $borrower    
	 * @param  [property] $authentication 
	 * @param  [property] $lead           
	 * @param  [array] $instance_url   
	 * @return Contact ID                
	 */
	public function contactCreation($borrower, $authentication, $lead, $instance_url, $doc_urls)
	{		
		/* Contact Creation */
		$contact['FirstName']=$borrower->first_name;	
		$contact['MiddleName']=$borrower->middle_name;		
		$contact['LastName']=$borrower->last_name;
		$contact['Lead__c']=$lead;
		switch ($borrower->residence_type) {
			case 'Owned - 1 BHK':
			case 'Owned - 2 BHK':
			case 'Owned - 3 BHK':
				$contact['Residence_Type__c']="Owned";
				$contact['Home_Owner__c']="Owned";
				break;
			case 'Rented - 1 BHK':
			case 'Rented - 2 BHK':
			case 'Rented - 3 BHK':
			case 'Company Provided':
				$contact['Residence_Type__c']="Rented";
				$contact['Home_Owner__c']="Rented";
				$contact['OtherStreet']=$borrower->permanent_address;
				$contact['OtherCity']=$borrower->permanent_city;
				$contact['OtherState']=$borrower->permanent_state;
				$contact['OtherPostalCode']=$borrower->permanent_pincode;				
				$contact['OtherCountry']="India";
				break;
			default:
				$contact['Residence_Type__c']="Parental";
				$contact['Home_Owner__c']="Parental";
				break;
		}	
		$borrower_profession=$borrower->nature_of_income;
		
		if ($borrower_profession == "Salaried/Wages") {
			$contact['Sector__c']="Salaried";
		} elseif ($borrower_profession == "Self employed") {
			$contact['Sector__c']="SENP";
		} else {
			$contact['Sector__c']="Others";
		}
		$contact['Phone']=$borrower->mobile_number;
		$contact['Nationality__c']="Indian";
		$contact['Gender__c']=$borrower->gender;
		
		/*$address_proof_type = $borrower->application->documents()
											->where('type','Address-proof')
											->first();
		if ($address_proof_type!='') {
			
			switch ($address_proof_type->name) {
			
			case 'Election/Voting Card':
				$contact['Permanent_Address_Proof_Type__c']="Voters Identity Card";
					break;
			case 'Ration Card':
				$contact['Permanent_Address_Proof_Type__c']="Ration Card";
					break;
			case 'Electricity Bill':
				$contact['Permanent_Address_Proof_Type__c']="Electricity Bill";
					break;
			case 'Water Bill':
				$contact['Permanent_Address_Proof_Type__c']="Water Bill";
					break;
			case 'Postpaid landline phone Bill':
				$contact['Permanent_Address_Proof_Type__c']="Postpaid Mobile Bill";
					break;
			case 'Passport':
				$contact['Permanent_Address_Proof_Type__c']="Valid Passport";
					break;
			case 'Permanent Driving License':
				$contact['Permanent_Address_Proof_Type__c']="Driving License";
					break;
			case 'Rent Agreement':
				$contact['Permanent_Address_Proof_Type__c']="Rent Agreement";
					break;
			case 'Bank Statement (only of scheduled/commercial banks)':
				$contact['Permanent_Address_Proof_Type__c']="Bank Account Statement";
					break;
			case 'Gas Connection (only PSU)':
				$contact['Permanent_Address_Proof_Type__c']="Gas Connection Bill";
					break;
			case 'Municipal tax Bill':
			case 'House Purchase Deed':
				$contact['Permanent_Address_Proof_Type__c']="Property Tax Receipt";
					break;		
			default:
				$contact['Permanent_Address_Proof_Type__c']="";
				break;
			}
			$contact['Permanent_Address_Proof_Image__c']=$doc_urls['Address-proof'];			
		}*/
		
		$contact['Borrower_Type__c']=$borrower->type;
		$contact['Father_Name__c']=$borrower->middle_name;
		
		$contact['Marital_Status__c']=$borrower->marital_status;
		$contact['Address_Category__c']="Residential";
		$contact['Birthdate']=$borrower->date_of_birth;
		if ($borrower->type=='Primary' && $borrower->application->self_patient) {
			$contact['Description__C']="Patient is same as borrower";
			$contact['Relation_with_the_Patient__c']="Self-Patient";
		} else {
			$contact['Relation_with_the_Patient__c']=$borrower->relation_with_patient;
		}
		
		$contact['Since_Residing_on_the_Current_Address__c']=$borrower->residing_since;
		$contact['Aadhaar_Number__c']=$borrower->aadhar_card_number;	
		$contact['PAN_ID__c']=$borrower->pan_card_number;
		$contact['Email']=$borrower->email;
		$contact['Mode_of_Loan_Repayment__c']=$borrower->application->mode_of_payment;
		if ($borrower->type=='Primary') {
			$contact['CIBIL_Score__c']=$borrower->application->cibil_score;
		}
		
		//$contact['Company_Name__c']=$borrower->name_of_firm;
		$contact['MailingStreet']=$borrower->address_line_1.' '.$borrower->address_line_2;
		$contact['MailingCity']=$borrower->city;
		$contact['MailingState']=$borrower->state;
		$contact['MailingPostalCode']=$borrower->pincode;
		$contact['MailingCountry']="India";
		
		$contact['Monthly_Income__c']=$borrower->borrowers_income;

		if (!$borrower->application->psychometricTest->isEmpty()) {

			if($application->psychometricTest()->where('test_url','!=','')->count()>0) {
                if ($borrower->application->psychometricTest()->where('test_url','!=','')->latest()->first()->result == 'Rejected') {
		        	$contact['Psychometric_Result__c']="Reject";
				} elseif($borrower->application->psychometricTest()->where('test_url','!=','')->latest()->first()->result == 'Accepted') {
		        	$contact['Psychometric_Result__c']="Give Loan";
		      	} else {
		      		$contact['Psychometric_Result__c']="NA";
		      	}
            } else {
	        	$contact['Psychometric_Result__c']="NA";
	        }	
		} else {
        	$contact['Psychometric_Result__c']="NA";
        }	    
		
		$contact['Name_of_Firm_Company_Establishment_In__c']=$borrower->name_of_firm;
		$contact['Whether_Income_is_Considered__c']="true";
		$contact['KYC_Documents__c']="true";
		$contact['No_of_Dependents__c']=$borrower->number_of_dependants;
		/* End of contact Creation */
		$contact=json_encode($contact);
		Log::info('borrower contact='.$contact);
		$contact_url = $instance_url."/services/data/v39.0/sobjects/contact";
		// Create a request with auth credentials
		$contact_url_response = $authentication->request('POST',$contact_url,['body'=>$contact]);
		// Get the actual response without headers
		//$contact_response = $contact_url_response->getBody();
		$contact_response =json_decode($contact_url_response->getBody(), true);
		$contact_id= $contact_response['id'];
		return $contact_id;
	}

	/**
	 * Update Lead for a this application
	 * @param  [property] $lead    
	 * @param  [property] $authentication         
	 * @param  [property] $instance_url   
	 * @return Lead ID                 
	 */
	public function convertLead($id)
	{
		$application = Application::find($id);
		$connection = $this->connectionToDMIServer();
		$authentication = $connection['authentication'];
		$instance_url = $connection['instance_url'];
		/* Update Lead */
		
		$body['Ready_for_Conversion__c']="Yes";	
		
		/* End of Update Lead  */
		$body=json_encode($body);	
		$lead_url = $instance_url."/services/data/v39.0/sobjects/lead/".$application->lead_id;
		// Create a request with auth credentials
		$lead_url_response = $authentication->request('PATCH',$lead_url,['body'=>$body]);
		$lead_response =json_decode($lead_url_response->getBody(), true);
		
		$application->dmi_status='converted';
		$application->save();

		Session::flash('info','Lead Converted');
      	return redirect()->back();
	}

	/**
	 * multiBureau for this contact
	 * @param  [property] $contact    
	 * @param  [property] $authentication         
	 * @param  [property] $instance_url   
	 * @return multibureau ID                 
	 */
	public function multiBureau($application,$contact, $authentication, $instance_url)
	{
		/* Multi Bureau */
		$body['Bureau__c']="CIBILTUSC2";	
		$body['Contact__c']=$contact;
		$body['Response__c']="";
		$body['Score__c']=$application->cibil_score;
		/* End of Multi Bureau  */
		$body=json_encode($body);
		Log::info('multiBureau ='.$body);	
		$multiBureau_url = $instance_url."/services/data/v39.0/sobjects/Multibureau_Data__c";
		// Create a request with auth credentials
		$multiBureau_url_response = $authentication->request('POST',$multiBureau_url,['body'=>$body]);
		// Get the actual response without headers
		//$lead_response = $multiBureau_url_response->getBody();
		$multiBureau_response =json_decode($multiBureau_url_response->getBody(), true);
		$multiBureau_id= $multiBureau_response['id'];
		return $multiBureau_id;
	}

	/**
	 * Get Dmi 
	 * @param  [string] $status (new,accepted,rejected)
	 * @return \Illuminate\Http\Response          
	 */
	public function getDmi($status)
	{
		$applications=Application::where('dmi_status',$status)->get()->sortByDesc('id');
		return view('admin.pages.dmi.index')->with(['applications'=>$applications,'status'=>$status]);
	}

	/**
	 * Display all the new status DMI
	 * @param  Request $input 
	 * @return \Illuminate\Http\Response             
	 */
	public function index(Request $input)
	{
		//get the user api token.
		$user_token =$input->get('token');
		//check whether user enter status or not.if not, show error message.
		if ($this->api_token!=$user_token) return ["success"=>false,"message"=>"Authentication failed"];
		$application=Application::where('dmi_status','new')->get();
		
		return ["success"=>true,"message"=>$application];
	}

	public function sendBulkPIN(Request $input)
	{	
		$connection = $this->connectionToDMIServer();
		$authentication = $connection['authentication'];
		$instance_url = $connection['instance_url'];

		$pin_numbers=explode(',',$input->get('pin_numbers'));
		$applications=Application::whereIn('pin_number',$pin_numbers)->get();
		
		foreach ($applications as $application) {

			$this->initiate($application, $authentication, $instance_url);

			$id = $application->id;
			$this->convertLead($id);
		}
		
		Session::flash('info','Applications Send to DMI');        
        return redirect()->back();
    	//$pin_numbers=explode(',',$input->get('pin_numbers'));
		/*$applications=Application::where('status','rejected')->get();
		//dd($applications);
		
		foreach ($applications as $application) {
			//$documents= $application->documents->where('status','Other-zip');
			foreach ($application->documents as $document) {
				$file_path=public_path()."documents/{$application->id}/{$document->file}";
				//$file_path="documents/{$application->id}/{$document->file}";
				//dd($file_path);
				if (File::exists($file_path)) {
			        unlink($file_path);				        
			    }
			    $document->delete();
			}				
		}
		Session::flash('info','document deleted');        
    	return redirect()->back();*/
	}

	/**
	 * [sendDocumentToDMI send all the application related documents to DMI AWS Bucket]
	 * @param  [object] $application 
	 * @return [type] 
	 */
	public function sendDocumentToDMI($application)
	{
		
		$documents = $application->documents;
		//dd($documents);
		/*$other_documents = $application->documents()->where('type','others')->get();*/
		$doc_urls = collect();
		foreach ($documents as $key=>$document) { 
		//dd($key);         
            $file = $document["file"];
            $doc_type = $document["type"];
            //dd($doc_type);
            if ($file) {
                $storage = Storage::disk('s3')->put('images/AF-'.$application->id.'/'.$file,file_get_contents(
                	public_path().'/documents/'.$application->id.'/'.$file));
                /*$storage = Storage::disk('s3')->put('images/AF-'.$application->id.'/'.$file,file_get_contents(
                	public_path().'/documents/'.$application->id.'/'.$file));*/
                $doc_urls->put($doc_type,'https://s3.ap-south-1.amazonaws.com/dmiarogya/images/AF-'.$application->id.'/'.$file);
                Log::info('document '.$file.' = '.$storage);
            }
        }
        /*foreach ($other_documents as $key=>$document) {          
            $file = $document["file"];
            $doc_name = $document["name"];
            
            if ($file) {*/
                /*$storage = Storage::disk('s3')->put('images/AF-'.$application->id.'/'.$file,file_get_contents(
                	public_path().'/documents/'.$application->id.'/'.$file));*/
               /* $storage = Storage::disk('s3')->put('images/AF-'.$application->id.'/'.$file,file_get_contents(
                	public_path().'/documents/'.$application->id.'/'.$file));
                $doc_urls->put($doc_name,'https://s3.ap-south-1.amazonaws.com/dmiarogya/images/AF-'.$application->id.'/'.$file);
                Log::info('document '.$file.' = '.$storage);
            }
        }*/

        //dd($doc_urls);
		return $doc_urls;
	}

	public function sendDmi()
	{
		//initialize empty collection
		$document_url = collect();

		$documents = Document::whereIn('application_id', [572, 1494, 3445, 3485, 3700, 3782, 3802, 3847, 3876, 3893, 4038, 4044, 4056, 4094])->where('type', 'Income-proof')->get();

		foreach ($documents as $document) {
			$application_pin_number = $document->application->pin_number;
			$document_file = $document->file;

			//put files in s3 bucket aws
		  	/*$storage = Storage::disk('s3')->put('images/AF-'.$document->application_id.'/'.$document_file,file_get_contents(
                	public_path().'/documents/'.$document->application_id.'/'.$document_file));*/

		  	//put document url in collection
			$document_url->put($application_pin_number,'https://s3.ap-south-1.amazonaws.com/dmiarogya/images/AF-'.$document->application_id.'/'.$document_file);
		}
		return $document_url;
	}
}
