<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: RegisterController.php
# Created on : JULY 2018
# Purpose: Controller for memeber registration management at frontend
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Event;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
	// default call	
	public function index()
    {	 		 
		$arrMetaVals= array(
			"meta_title" => 'Register - Myscorebet',
			"meta_keywords" => 'Best Site to Bet on Football Games',
			"meta_description" => 'Myscorebet is the one of the Best Football Betting Sites in UK.'
		);
		
		return view('frontend.registerContent',compact('arrMetaVals')); 			 
	}	
}
