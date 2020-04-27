<?php

namespace App\Http\Controllers\Website\StaticPage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Question;
use App\Option;
use App\Hospital;

class PageController extends Controller
{
   /**
    * Returns the homepage
    * @return
    */
	public function home($locale=null)
	{	if ($locale) {
			app()->setLocale($locale);
		} else {
			$locale='en';
			app()->setLocale($locale);
		}
		
		return view('website.pages.static_pages.home')->with(['locale'=>$locale]);
	}

	/**
	 * Returns how it works page
	 * @return
	 */
	public function work()
	{
		return view('website.pages.static_pages.how_it_works')->with(['locale'=>'en']);
	}

	/**
	 * Show faq page to the user.
	 *
	 * @return
	 */
	public function faq()
	{
		return view('website.pages.static_pages.faq')->with(['locale'=>'en']);
	}


	/**
	 * Show partner page to the user.
	 *
	 * @return
	 */
	public function hospitalPartners()
	{
		$hospitals = hospital::all();
		return view('website.pages.static_pages.partners')->with(['hospitals'=>$hospitals,'locale'=>'en']);
	}


	/**
	 * Show partner page to the user.
	 *
	 * @return
	 */
	public function industryPartners()
	{
	
		return view('website.pages.static_pages.industry-partners')->with(['locale'=>'en']);
	}


	/**
	 * Show partner page to the user.
	 *
	 * @return
	 */
	public function associatePartners()
	{
		$associatePartners = array('Basix',
									'Sahaj e village ',
									'Lets MD',
									'Quikrupee',
									'PS Takecare',
									'Yes2treatment',
									'Medicaid Ethos',
									'Swavalamban Consultancy',
									'Zelthy',
									'CreditMantri',
									'Bharati Echo Health Private Limited',
									'Rakesh Rokade',
									'Kanakendu Chakarabarty',
									'Sanjoy Halder',
									'Ravindra Gangurde',
									'Krishna Lad',
									'Shyamadhar Shukla',
									'Dipanjan Dasgupta',
									'Missula Associates Pvt Ltd.',
									'Nectors Healthtech',
									'PayMeds',
									'Netmeds Marketplace Limited',
									'Apollo Pharmacy',
									'Thyrocare'
									);
		return view('website.pages.static_pages.associate-partners')->with(['associatePartners'=>$associatePartners,'locale'=>'en']);
	}


	/**
	 * Show about page to the user.
	 *
	 * @return
	 */
	public function about()
	{
		return view('website.pages.static_pages.about')->with(['locale'=>'en']);
	}


	/**
	 * Show rewards page to the user.
	 *
	 * @return
	 */
	public function press()
	{
		return view('website.pages.static_pages.press')->with(['locale'=>'en']);
	}


	/**
	 * Show management page to the user.
	 *
	 * @return
	 */
	public function ourBoard()
	{
		return view('website.pages.static_pages.our_board')->with(['locale'=>'en']);
	}


	/**
	 * Show sitemap page to the user.
	 *
	 * @return
	 */
	public function sitemap()
	{
		return view('website.pages.static_pages.sitemap')->with(['locale'=>'en']);
	}

	/**
	 * Show advisory Board page
	 * @return 
	 */
	public function advisoryBoard() {
		return view('website.pages.static_pages.advisory_board')->with(['locale'=>'en']);
	}

	public function management() 
	{
		return view('website.pages.static_pages.management')->with(['locale'=>'en']);
	}

	/**
	 * Show CEO Speaks page
	 * @return 
	 */
	public function ceoSpeaks() {
		return view('website.pages.static_pages.ceo_speaks')->with(['locale'=>'en']);
	}
}
