<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: MyaccountController.php
# Created on : JULY 2018
# Purpose: Controller for memeber account management at frontend
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Event;
use App\Member;
use App\UserScorePrediction;
use Illuminate\Http\Request;
use Hash;
use Session;
use URL;

class MyaccountController extends Controller
{
	// default call	
	public function index()
    {	
     	$sess_customer_id = Session::get('cd_customer_id');
     	$arrUserPredictions = UserScorePrediction::userPredictions($sess_customer_id);

     	$arrPredictions= array();
     	if($arrUserPredictions) {
			foreach($arrUserPredictions as $data) {
				$arrPredictions[$data['event_name']]['subevent_data'][] = $data;
			}
		}

		//Get member details
		$arrUserData = Member::getMemberDetails($sess_customer_id);
		return view('frontend.myaccountContent',compact('arrPredictions', 'arrUserData'));
	}	
	
	// function to authenticate user
	public function auth(Request $request)
    {	  
	    $sess_customer_email = $request->session()->get('cd_customer_email');
	  
		request()->validate([ 
            'old_password' => 'required',
			'new_password' => 'required',
			'confirm_password' => 'required'
        ]);
		
		// get password from tbl	
		$sql_mem = DB::table('members')
                     ->select(DB::raw('id,first_name,last_name,password'))
                     ->where([
								['isActive','=','y'], 
								['isDeletedByUser','=','n'],
								['email','=',$sess_customer_email]		
					  ])->first();
		
		if($request->new_password != $request->confirm_password) {			 
			return redirect('/myaccount')->with('danger','New password does not match the confirm password');	
		}	
		else if (Hash::check($request->old_password,$sql_mem->password)) {
			 			 
			DB::table('members')
            ->where('email', $sess_customer_email)
            ->update(['password' =>  Hash::make($request->new_password)]); 
			 
			 //Send an email to user for changing password
            $strCustomerName		= $sql_mem->first_name." ".$sql_mem->last_name;
            $strCustomerMailSubject = config('emailcontents.emails.5.subject');
            $strCustomerMessage     = config('emailcontents.emails.5.message');
            $strCustomerMessage     = str_replace('[USER_NAME]',$strCustomerName, $strCustomerMessage);
            $strCustomerMessage     = str_replace('[SITE_LOGIN_URL]', URL::to('/login'), $strCustomerMessage);
        
            $isSent = sendEmail(trim($sess_customer_email), $strCustomerName, $strCustomerMailSubject,$strCustomerMessage,"");

			return redirect('/myaccount')->with('success','Password updated successfully.');			
		} else {						 
			return redirect('/myaccount')->with('danger','Old password does not match with registered password');		
		}	 	 
	} 

	// function to delete predictions
	public function deletePrediction($userpredictionid) {
		//Get user prediction
		$intuserpredictionid = base64_decode($userpredictionid);

		//If event found
		if($intuserpredictionid!='') {
			//Delete  user predictions 
			UserScorePrediction::destroy($intuserpredictionid);
            return redirect('/myaccount')->with('success', trans('app.prediction_destroy'));
		}
	}

	//Delete Member Account
	public function deleteMemberAccount($id) {
		$intUserId = base64_decode($id);
		$objDeleteMember = Member::deleteMember($intUserId);
		        
        Session::flush();
		// flush login user values
		Session::forget('cd_customer_id');
		Session::forget('cd_customer_name');
		Session::forget('cd_customer_email');
		return redirect('/')->with('success', trans('app.member_account_destroy'));
	}
}
