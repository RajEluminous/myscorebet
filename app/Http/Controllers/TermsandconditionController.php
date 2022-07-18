<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Event;
use Illuminate\Http\Request;

class TermsandconditionController extends Controller
{
	// default call	
	public function index()
    {	 	 
		$arrMetaVals= array(
			"meta_title" => 'Terms and Condition -Myscorebet',
			"meta_keywords" => 'Site that Predict Football Matches Correctly, Best Football Prediction Site of the Year, Best Football Prediction Site in the world, Best Football betting Sites UK.',
			"meta_description" => 'Free football predictions site and tips in England, Myscorebet is the best. If you are looking for site that predict football matches Correctly.'
		);
		return view('frontend.termsandconditionContent',compact('arrMetaVals'));  				 
	}	
}
