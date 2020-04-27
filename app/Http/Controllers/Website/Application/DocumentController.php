<?php

namespace App\Http\Controllers\Website\Application;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Hospital;
use App\Borrower;
use App\Application;
use Session;
use App\Helpers\Alerts;
use App\Http\Controllers\Website\Application\PersonalDetailController;

class DocumentController extends Controller
{
    /**
     * Ask For Documents Upload 
     * @param  $type Application type loan/card
     * @param  $id   Application id
     * @return redirect  Check-eligibility test
    */
    public function askDocumentsUpload($type, $id, Request $input)
    {   
        $personal_detail_object = new PersonalDetailController();
        $locale = $personal_detail_object->checkLocal($input);
        app()->setLocale($locale);
        return view('website.pages.application.ask_documents_upload')
             ->with(['type' => $type, 'id' => $id, 'locale' => $locale ]);
    }

    /**
     * Show form for documents
     * @return
    */
    public function showDocuments($type, $id, Request $input)
    {   
        $personal_detail_object = new PersonalDetailController();
        $locale = $personal_detail_object->checkLocal($input);
        app()->setLocale($locale);
        $hospitals = Hospital::all()->pluck('name');
        $application = Application::find($id);
        return view('website.pages.application.documents')
             ->with(['type' => $type, 'hospitals' => $hospitals, 'id' => $id, 
                     'application'=>$application, 'locale' => $locale ]);
    }

    /**
     * Post Application Documents
     * @param  $type                    [type of application(loan/card)]
     * @param  Request $input           [Array of form input fields]
     * @return [redirect route]         [redirects to check eligibility]
    */
    public function postDocuments($type, $id, Request $input)
    {
        $personal_detail_object = new PersonalDetailController();
        $locale = $personal_detail_object->checkLocal($input);
        app()->setLocale($locale);
        $application = Application::find($id);
        // save documents.
        $success = $this->saveDocuments($application, $input);
        
        //check if the borrower is applying for psychometric test.
        return redirect('/eligibility/self-psychometric/'.$id.'?locale='.$locale);  
        
        //check the eligibility test for this application.
        //return redirect('/eligibility/check-eligibility/'.$id.'?locale='.$locale);  
    }

    /**
     * Update Application
     * @param  Request $input [description]
     * @return [type]         [description]
    */
    public function update(Request $input)
    {
        if (Session::has('borrower_id')) {

            // get the user

            $borrower = Borrower::find(Session::get('borrower_id'));
            $application = $borrower->application;
            $this->saveDocuments($application, $input);

            // if($form->remainingDocumentsCount()==0)
            // {
            //   Session::forget('user_id');
            //   $user->reference_code="invalid";
            //   $user->save();
            //   Session::flash('message', Alerts::DOCUMENT_UPLOAD_MESSAGE);
            //   return redirect('/');
            // }
            // finally save form object
            // $form->save();
            // set session message

            Session::flash('message', Alerts::DOCUMENT_UPLOAD_MESSAGE);

            // update form

            return redirect('/user/dashboard');
        }
        else {
            return response('Unauthorized.', 401);
        }
    }
    
    /**
     * Save documents for the application
     * @param  App\Application  $application
     * @param  Request $input
     * @return
    */
    public function saveDocuments($application, Request $input)
    {
        $basePath = public_path()."/documents/" . $application->id;
        if ($input->has('documents')) {
            foreach($input->all() ['documents'] as $document) {
                if (array_key_exists("files", $document)) {
                    foreach($document['files'] as $file) {
                        if (array_key_exists("type", $document)) {
                            $type = $document["type"];
                        }
                        else {
                            $type = 'additional-documents';
                        }

                        if ($file != null) {
                            $documentName = $document["name"];
                            $type = $document["type"];
                            $fileName = str_slug($documentName) . "_" . str_random(5) . "." . $file->getClientOriginalExtension();

                            // move file

                            $file->move($basePath, $fileName);
                            $application->documents()->create(["file" => $fileName, "name" => $documentName, "type" => $type]);
                        }
                    }
                }
            }
        }

        return true;
    }    

    /**
     * Submit Application Without Documents
     * @param  $type application type loan/card
     * @param  $id   application id
     * @return redirect       eligibility test
     */
    public function submitApplicationWithoutDocs($type, $id, Request $input)
    {
        $personal_detail_object = new PersonalDetailController();
        $locale = $personal_detail_object->checkLocal($input);
        app()->setLocale($locale);
        return redirect('/eligibility/check-eligibility/'.$id.'?locale='.$locale);
    }
    
}
