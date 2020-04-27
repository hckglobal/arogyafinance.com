<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Borrower;
use Mail;
use PDF;
use Image;
use File;

class SendBirthdayEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendBirthdayEmails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Birthday Email to all the patients.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $date = Carbon::now();
        $today_with_year = $date->format('m-d-Y');
        $today = $date->format('m-d');
        $borrowers = Borrower::where('type','primary')->where('date_of_birth','like','%'.$today.'%')->get();
        foreach ($borrowers as $borrower) {  
            // create Image from file
            $img = Image::make(public_path().'/birthday-card.jpg');
            // use callback to define details
            $img->text('Dear '.$borrower->first_name.' '.$borrower->last_name, 200, 100, function($font) {
                $font->file(public_path().'/assets/fonts/OpenSans-SemiBold.ttf');
                $font->size(25);
                $font->color('#613e1e');
                $font->align('center');
                $font->valign('top');
            });
            // finally we save the image as a new file
            if (file_exists(public_path().'/birthday-cards/'.$today_with_year))
            {
                $birthday_card = $img->save(public_path().'/birthday-cards/'.$today_with_year.'/'.$borrower->first_name.'.jpg');
            } else {
                $file = File::makeDirectory(public_path().'/birthday-cards/'.$today_with_year, 0775, true);
                $birthday_card = $img->save(public_path().'/birthday-cards/'.$today_with_year.'/'.$borrower->first_name.'.jpg');
            }
            //$birthday_card = $img->response('jpg');
            Mail::send('emails.admin.birthday_card', ['borrower'=>$borrower, 'birthday_card'=>$birthday_card],
                function ($mail) use ($borrower, $birthday_card)
                {
                  $mail->to($borrower->email, 'Arogya Finance')
                                    ->subject('Happy Birthday');
                });
        
        }                    
    }
}
