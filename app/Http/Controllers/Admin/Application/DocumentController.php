<?php

namespace App\Http\Controllers\Admin\Application;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Note;
use Session;
use Redirect;
use Zipper;
use Carbon\Carbon;
use App\User;
use App\Application;
use PDF;
use Input;
use App\Borrower;
use App\Log;
use App\Location;
use App\Helpers\SMSProvider;
use App\Helpers\Alerts;
use Terbilang;
use App\RejectionReason;
use App\Product;
use App\Reference;
use App\Hospital;
use App\RepaymentCheque;
use App\FamilyMember;
use App\Document;
use File;

class DocumentController extends Controller
{
    /**
     * Save photo for the application
     * @param  $id
     * @param  Request $input
     * @return \Illuminate\Http\Response
     */
    public function uploadApplicationPhoto($id, Request $input)
    {
        $application = Application::find($id);
        
        if ($input->hasFile('photo')) {

            /*$basePath = public_path()."/documents/".$application->id;*/
            $basePath = public_path()."/documents/".$application->id;
            $file = $input->file('photo');
            $fileName = str_slug($file->getClientOriginalName()) . "_" . str_random(5) . "." . $file->getClientOriginalExtension();
            $type = "photo";
            $file->move($basePath, $fileName);
            $application->documents()->create(["file" => $fileName, "name" => $type, "type" => $type]);
            Session::flash('info','Photo Uploaded');
            
            return redirect()->back();
        }
        if ($input->hasFile('new_photo')) {
            $photos=$application->documents()->where('type','photo')->get();
            
            foreach ($photos as $photo) {
                $image_path = public_path()."/documents/".$application->id."/".$photo->file;
                
                if (File::exists($image_path)) {
          
                    File::delete($image_path);
                    Document::destroy($photo->id);
                }
            }
      
            $basePath = public_path()."/documents/".$application->id;
            $file = $input->file('new_photo');
            $fileName = str_slug($file->getClientOriginalName()) . "_" . str_random(5) . "." . $file->getClientOriginalExtension();
            $type = "photo";
            $file->move($basePath, $fileName);
            $application->documents()->create(["file" => $fileName, "name" => $type, "type" => $type]);
            Session::flash('info','Photo Updated');
            
            return redirect()->back();
        }    
    }

    /**
     * Download all the document as Zip for this application
     * @param  [int] $id [application id]
     * @return \Illuminate\Http\Response
     */
    public function downloadZip($id)
    {
        $headers = ["Content-Type"=>"application/zip"];
        $fileName = $id.".zip";

        // Add these
        // ob_clean();
        // flush();

        Zipper::make(public_path('/documents/'.$id.'.zip'))
                ->add(public_path()."/documents/".$id.'/')->close();
        
        return response()
        ->download(public_path('/documents/'.$fileName),$fileName, $headers);
    }


    public function deleteDocuments(Request $input)
    {
        // get all documents
        $document_ids = $input->get('documents');

        foreach ($document_ids as $id) {
            Document::destroy($id);
        }
        return redirect()->back();
    }
}
