<?php
namespace App\Http\Controllers\Admin\Dashboard;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Application;
use Image;

class DashboardController extends Controller
{
    public function show()
    {
        $title = "Dashboard";
        //dd(Application::card()->whereIn('cibil_score', [-100, -99])->count());
        /*if(Auth::user()->applications) {*/
            $user = Auth::user();
            $loanForms = Auth::user()->applications()->loan()->count();
            $cardForms = Auth::user()->applications()->card()->count();
            $unCatLoan  = Application::loan()->whereIn('cibil_score', [-100, -99])->count();
            $unCatCard  = Application::card()->whereIn('cibil_score', [-100, -99])->count();
        /*} else {
            $loanForms = 0;
            $cardForms = 0;
            $unCatLoan  = 0;
            $unCatCard  = 0;
        }*/
        $link=env('APP_URL');
        //dd($loanForms,$cardForms,$unCatCard,$unCatLoan,$link,$title);
        return view('admin.pages.dashboard')
             ->with(['title'=>$title,'loanForms'=>$loanForms,'cardForms'=>$cardForms, 
                  'unCatLoan'=>$unCatLoan, 'unCatCard'=>$unCatCard,'link'=>$link,'user'=>$user]);
    }

    public function changeLogs()
    {
        $title = "Change Logs";
        return view('admin.pages.change-logs',['title'=>$title]);
    }

    public function birthdayCard()  
    {
        // create Image from file
        $img = Image::make(public_path().'/birthday-card.jpg');

        // use callback to define details
        $img->text('Dear Mr.Prashant Kumbhar', 250, 100, function($font) {
            $font->file(public_path().'/assets/fonts/OpenSans-SemiBold.ttf');
            $font->size(27);
            $font->color('#613e1e');
            $font->align('center');
            $font->valign('top');
        });
        return $img->response('jpg');
    }
}
 