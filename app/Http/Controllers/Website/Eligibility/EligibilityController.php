<?php

namespace App\Http\Controllers\Website\Eligibility;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Question;
use Session;
use App\Borrower;
use App\Application;
use File;
use App\PsychometricTest;
use App\Http\Controllers\Website\Application\PersonalDetailController;
use App\Traits\SelfPsychometric;
use App\Helpers\Alerts;

class EligibilityController extends Controller
{
    use SelfPsychometric;
    /**
     * check if borrower is applying for psychometric test.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function checkSelfPsychometric($id, Request $input)
    {
        $personal_detail_object = new PersonalDetailController();
        $locale = $personal_detail_object->checkLocal($input);
        app()->setLocale($locale);
        return view('website.pages.eligibility-test.psychometric_self_check',[
            'application_id'=>$id, 
            'locale' => $locale,
        ]);
    }

    /**
     * check if borrower is applying for psychometric test or not.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function checkPsychometric($id, Request $input)
    {
        $application = Application::find($id);
        $result = $this->checkIfBorrowerIsApplyingForPsychometricTest($id, $input);
        if($result==true) {
            return redirect('/eligibility/check-eligibility/'.$id);
        } else {
            $message = Alerts::WELCOMEMESSAGEWITHOUTPSYCHOMETRICTESTFC($application);
            $next_url = '/';
            
            Session::forget('borrower_id');

            return view('website.pages.application.thank_you')
             ->with(['message'=>$message,'next_url'=>$next_url,'application'=>$application,'locale'=>'en']);    
    
        }
    }

    /**
     * check the eligibility for test.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function checkEligibility($id, Request $input)
    {
        $personal_detail_object = new PersonalDetailController();
        $locale = $personal_detail_object->checkLocal($input);
        app()->setLocale($locale);
        $application = Application::find($id);
        if($application->category()=="One" || $application->category()=="Two"){
            return redirect('/payment/ask-for-payment/'.$id);            
        } else {
            return redirect('/eligibility/select-language');       
        }        
    }

    /**
     * select language for eligibility test.
     * @return \Illuminate\Http\Response
    */
    public function selectLanguage(Request $input)
    {   
        $personal_detail_object = new PersonalDetailController();
        $locale = $personal_detail_object->checkLocal($input);
        //dd($locale);
        app()->setLocale($locale);
        $borrower_id = Session::get('borrower_id');
        $borrower = Borrower::find( $borrower_id);
        $reference_code = $borrower->application->reference_code;

        //check if the borrower is salaried 
        if(strpos(strtolower($borrower->nature_of_income), 'salaried') !== false){
            $test_id = 4;
        }else{
            $test_id = 5;
        }

        $test_link = "https://test.arogyafinance.com/arogya/candidate/create/".$test_id;

        return view('website.pages.eligibility-test.select_language',[
            'reference_code'=>$reference_code, 
            'locale' => $locale,
            'test_link' => $test_link
        ]);
    }

    /**
     * Eligibility test instructions
     * @return \Illuminate\Http\Response
    */
    public function instruction($locale)
    {
        switch ($locale) {
            case 'en':
                return view('website.pages.eligibility-test.instruction_en');
                break;
            case 'hi':
                return view('website.pages.eligibility-test.instruction_hi');
                break;
            case 'gu':
                return view('website.pages.eligibility-test.instruction_gu');
                break;
            case 'mr':
                return view('website.pages.eligibility-test.instruction_mr');
                break;
            case 'bn':
                return view('website.pages.eligibility-test.instruction_bn');
                break;
            default:
                echo "alert('ERROR! Invalid Language')";
                break;
        }
    }

    /**
     * Fetch questions for the test.
     *
     * @return \Illuminate\Http\Response
    */
    public function getTest($locale)
    {
        $borrower_id = Session::get('borrower_id');
        $borrower = Borrower::find( $borrower_id);
        $questionsArray=collect();
       /* $questionsArray["integrityLow"] = Question::Integrity()->Low()->take(3)->get();

        $questionsArray["integrityMedium"] = Question::Integrity()->Medium()->take(4)->get();

        $questionsArray["integrityHigh"] = Question::Integrity()->High()->take(3)->get();

        $questionsArray["abilityLow"] = Question::Ability()->Low()->take(3)->get();

        $questionsArray["abilityMedium"] = Question::Ability()->Medium()->take(4)->get();

        $questionsArray["abilityHigh"] = Question::Ability()->High()->take(3)->get();

        $questionsArray["intentionLow"] = Question::Intention()->Low()->take(3)->get();

        $questionsArray["intentionMedium"] = Question::Intention()->Medium()->take(4)->get();

        $questionsArray["intentionHigh"] = Question::Intention()->High()->take(3)->get();

        $questionsArray["riskLow"] = Question::Risk()->Low()->take(3)->get();

        $questionsArray["riskMedium"] = Question::Risk()->Medium()->take(4)->get();

        $questionsArray["riskHigh"] = Question::Risk()->High()->take(3)->get();*/
        $questionsArray=$questionsArray->merge(Question::Integrity()->Low()->take(3)->get());
        $questionsArray=$questionsArray->merge(Question::Integrity()->Medium()->take(4)->get());
        $questionsArray=$questionsArray->merge(Question::Integrity()->High()->take(3)->get());
        $questionsArray=$questionsArray->merge(Question::Ability()->Low()->take(3)->get());
        $questionsArray=$questionsArray->merge(Question::Ability()->Medium()->take(4)->get());
        $questionsArray=$questionsArray->merge(Question::Ability()->High()->take(3)->get());
        $questionsArray=$questionsArray->merge(Question::Intention()->Low()->take(3)->get());
        $questionsArray=$questionsArray->merge(Question::Intention()->Medium()->take(4)->get());
        $questionsArray=$questionsArray->merge(Question::Intention()->High()->take(3)->get());
        $questionsArray=$questionsArray->merge(Question::Risk()->Low()->take(3)->get());
        $questionsArray=$questionsArray->merge(Question::Risk()->Medium()->take(4)->get());
        $questionsArray=$questionsArray->merge(Question::Risk()->High()->take(3)->get());

        /*return view("website.pages.eligibility-test.test")->with(["questionsArray"=>$questionsArray,"borrower_id"=>$borrower_id,"locale"=>$locale]);*/
        return view("website.pages.eligibility-test.test")
             ->with(["questionsArray"=>$questionsArray->shuffle(),"borrower"=>$borrower,"locale"=>$locale]);
    }



    /**
     * handles the evaluation of pshychometric test.
     *
     * @return
    */
    public function postTest(Request $input)
    {

        $borrower_id = $input->get('borrower_id');
        $answers = $input->get('answers');
        $borrower = Borrower::find( $borrower_id);
        $application =$borrower->application;
        foreach ($answers as $answer) {

        $borrower->answers()->create(["question_id"=>$answer["question_id"],"option_id"=>$answer["option_id"]]);

        }
        
        //Session::forget('borrower_id');
        return view('website.pages.eligibility-test.test_complete')->with(['application'=>$application]);
    }

    /**
     * Capture Psychometric Test Screenshot 
     * @param  Request $input 
     * @param  [int]  $id    
     * @return          
     */
    public function screenshot(Request $input, $id)
    {
        Session::flash('info','captured');
        /*$data = $input->get('screenshot');
        dd($data);
        $uri = substr($data,strpos($data,",")+1);
        $borrower_id = $input->get('borrower_id');
        $filename = 'documents/screenshots/'.$borrower_id."_".$id.".png";
        file_put_contents($filename, base64_decode($uri));*/

        //input get image
        $image = $input->get('screenshot'); 

        
        //check if folder exists
        if(!File::exists('screenshot')) {
            //make directory by test id
             File::makeDirectory('screenshot');
        }

        
        //check for sub folders
        $path = "screenshot/".$id;
        if(!FiLE::exists($path)){
            //make sub folders
            file::makeDirectory($path);
        }
        
        //convert into image
        $uri = substr($image,strpos($image,",")+1);

        //make random name -> format is testId_randomstring(6)
        $file_name = $id."_".str_random(6).".png";

        $file_path = "screenshot/".$id."/".$file_name;

        //save image file
        file_put_contents($file_path,base64_decode($uri));
        //find borrower 
        $borrower = Borrower::find($id);

        //create screenshot
        $borrower->screenshots()->create(['borrower_id'=>$id,'url'=>$file_path]);
    }

    /**
     * Test complete 
     * @return \Illuminate\Http\Response
     */
    public function testcomplete()
    {
        $borrower_id = Session::get('borrower_id');
        $borrower = Borrower::find( $borrower_id);
        $application=$borrower->application;
        
        if ($application->type=="card" && $application->category()!="One") {
            return redirect('/payment/ask-for-payment/'.$application->id); 
        } elseif (Session::get('login')) {
            return redirect('/user/dashboard');
        } else {
            return redirect('/thank-you/'.$application->id);
        }        
    }

    /**
     * Show webcam Error 
     * @return \Illuminate\Http\Response
     */
    public function webcamError()
    {
        Session::forget('borrower_id');
        return view('website.pages.eligibility-test.webcam_error');
    }

    /**
     * get result from index]
     * @return \Illuminate\Http\Response
     */
    public function getResult($reference_code)
    {   //dd($reference_code);
        $client = new \GuzzleHttp\Client();       
        $psychometric_test_url=env('PSYCHOMETRIC_TEST_URL');
        $psychometric_test_api_token=env('PSYCHOMETRIC_TEST_API_TOKEN');
        $url=$psychometric_test_url."?username=".$reference_code."&api_token=".$psychometric_test_api_token;
        //dd($url);
        // Create a request
        $psychometric_test_url_response = $client->request('GET',$url);
        //dd($psychometric_test_url_response);        
        //decode the json retrived
        $psychometric_test_response =json_decode($psychometric_test_url_response->getBody()->getContents(), true);
        
        //dd($psychometric_test_response);
        if(!is_null($psychometric_test_response)) {
            //search application whose reference code is matching with given reference_code
            $application = Application::where('reference_code',$reference_code)->first();
            //add application to response array
            $psychometric_test_response['application_id'] = $application->id;
            // store psychometric test to database
            $psychometric_test = PsychometricTest::create($psychometric_test_response);

            if ($application->type=="card" && $application->category()!="One") {
                return redirect('/payment/ask-for-payment/'.$application->id); 
            } else {
                return redirect('/thank-you/'.$application->id);
            }
        }
    }

    public function getTestResultAPI()
    {
        $applications = Application::whereBetween('id',[8291,8390])->get();
        //dd($applications->count());
        foreach ($applications as $application) {
            $this->getResult($application->reference_code);
        }
        return "updated test-result";    
    }
}
