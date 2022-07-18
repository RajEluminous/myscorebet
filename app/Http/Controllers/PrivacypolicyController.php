<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Event;
use Illuminate\Http\Request;

class PrivacypolicyController extends Controller
{
	// default call	
	public function index()
    {	 	 
		$arrMetaVals= array(
			"meta_title" => 'Privacy Policy - Myscorebet',
			"meta_keywords" => 'Best football prediction site free, Site that Predict Football Matches Correctly, Best Football Prediction Site of the Year, Best Football Prediction Site in the world.',
			"meta_description" => 'Welcome to Myscorebet, best football prediction site free in UK.'
		);
		return view('frontend.privacypolicyContent',compact('arrMetaVals')); 					 
	}	
}
