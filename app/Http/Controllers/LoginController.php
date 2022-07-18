<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: LoginController.php
# Created on : JULY 2018
# Purpose: Controller for memebr login management at frontend
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Event;
use App\Member;
use Illuminate\Http\Request;
use Hash;
use Session;

class LoginController extends Controller
{
	// default call	
	public function index(Request $request)
    {	
		$arrMetaVals= array(
			"meta_title" => 'Login - MyScoreBet',
			"meta_keywords" => 'Best Site to Bet on Football Games, Best football prediction site free,  Best Football Prediction Site of the Year, Best Football Prediction Site in the world.',
			"meta_description" => 'Best Site to Bet on Football Games in England - Myscorebet'
		);
		
		return view('frontend.loginContent',compact('arrMetaVals')); 					 
	}	
		
	// logout user	
	public function logout()
    { 
		Session::flush();
		// flush login user values
		Session::forget('cd_customer_id');
		Session::forget('cd_customer_name');
		Session::forget('cd_customer_email');
		return redirect('/');
	}
	
	// function to authenticate user
	public function auth(Request $request)
    {	  
		request()->validate([ 
            'email' => 'required',
			'password' => 'required',
        ]);
		
		//Get member data form table	
		$sql_mem = DB::table('members')
                     ->select(DB::raw('id,first_name,last_name,password,isActive,isDeletedByUser'))
                     ->where([
							['email','=',trim($request->email)]		
					  ])->first();

        //Check user status
        if($sql_mem) {
        	if($sql_mem->isActive == 'y' && $sql_mem->isDeletedByUser == 'n') {
        		// check password verification
				if (Hash::check($request->password,optional($sql_mem)->password)) {
					$request->session()->put('cd_customer_id', $sql_mem->id);
					$request->session()->put('cd_customer_name', $sql_mem->first_name);
					$request->session()->put('cd_customer_email', $request->email);
					$request->session()->save();
					return redirect('/');			
				} else {			 		 
					return redirect('/login')->with('danger', trans('app.member_authentication_invalid'));	
				}
	        }

	        //If status is inactive
	        if($sql_mem->isActive == 'n' ) {
	        	return redirect('/login')->with('danger', trans('app.member_inactive_auth_status'));
	        }

	        //If status is inactive
	        if($sql_mem->isDeletedByUser == 'y' ) {
	        	return redirect('/login')->with('danger', trans('app.member_deleted_account'));
	        }
        }
        else {
        	return redirect('/login')->with('danger', trans('app.member_authentication_invalid'));	
        }
       //   $sql_mem = DB::table('members')
       //               ->select(DB::raw('id,first_name,last_name,password'))
       //               ->where([
							// 	['isActive','=','y'],
							// 	['isDeletedByUser','=','n'], 
							// 	['email','=',trim($request->email)]		
					  // ])->first();
	}	
}
