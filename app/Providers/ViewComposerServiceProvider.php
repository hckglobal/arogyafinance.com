<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Application;
use Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('admin.partials.sidebar',function($view)
        {
          //sidebar structure array
          $menu = [
          "types"=>[
            ["name"=>"Loan" ,"scope" =>"loan","icon_class"=>"glyphicon-file","permission"=>"view-loan-application"],
            ["name"=>"Card", "scope"=>"card","icon_class"=>"glyphicon-credit-card","permission"=>"view-card-application"],
         ],
          "statuses"=>[
              ["name"=>"Lead","scope" =>"lead", "icon"=>"glyphicon-pushpin"],
              ["name"=>"New","scope" =>"new", "icon"=>"glyphicon-new-window"],
              ["name"=>"Verified","scope" =>"verified", "icon"=>"glyphicon-tags"],
              ["name"=>"Sanctioned","scope" =>"sanctioned", "icon"=>"glyphicon-ok"],
              ["name"=>"Disbursed","scope" =>"disbursed", "icon"=>"glyphicon-check"],
              ["name"=>"Closed","scope" =>"closed", "icon"=>"glyphicon-flag"],
              ["name"=>"Rejected","scope" =>"rejected", "icon"=>"glyphicon-remove"],
            ],
          "categories"=>[
            ["name"=>"one","scope"=>"categoryOne"],
            ["name"=>"two","scope"=>"categoryTwo"],
            ["name"=>"three","scope"=>"categoryThree"],
            ["name"=>"four","scope"=>"categoryFour"],
            ["name"=>"none","scope"=>"categoryNone"]
          ]
         ];

         $user = Auth::user();
         $applications = $user->applications();
         $view->with(["menu"=>$menu,'user'=>$user,'applications'=>$applications]);
        });

        view()->composer('admin.partials.header',function($view)
        {
          $user = Auth::user();
          $applications = $user->applications();
          $view->with(['user'=>$user,'applications'=>$applications]);
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

// ["name"=>"New","scope" =>"new", "icon"=>"glyphicon-new-window","permission"=>"new-card-application-application"],
              // ["name"=>"Verified","scope" =>"verified", "icon"=>"glyphicon-tags","permission"=>"view-verified-card-application"],
              // ["name"=>"Sanctioned","scope" =>"sanctioned", "icon"=>"glyphicon-ok","permission"=>"view-sanctioned-card-application"],
              // ["name"=>"Rejected","scope" =>"rejected", "icon"=>"glyphicon-remove","permission"=>"view-rejected-card-application"],