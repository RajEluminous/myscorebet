<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: ForgotpasswordController.php
# Created on : JULY 2018
# Purpose: Controller for password management at frontend
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

namespace App\Http\Controllers;
use App\Member;
use Illuminate\Http\Request;
use Validator;
use Hash;
use URL;

class ForgotpasswordController extends Controller
{
	// default call	
	public function index(Request $request)
    {	 	
		$arrMetaVals= array(
			"meta_title" => 'Forgot Password - Myscorebet',
			"meta_keywords" => 'predictions for tomorrow soccer matches',
			"meta_description" => 'Here we publish our predictions for tomorrow soccer matches in UK.'
		);
		return view('frontend.forgotpasswordContent',compact('arrMetaVals')); 				 
	}	

	//Set Forgot password link
	public function setpass(Request $request)
    {	 
    	//validate form fields
        Validator::make($request->all(), [
            'fp_useremail'  => 'required'
        ])->validate();

        $objMemberData = Member::where('email', trim($request->fp_useremail))->where('isActive', 'y')->where('isDeletedByUser', 'n')->get()->first();
        if(isset($objMemberData)) {
             //Update token in database for member
        	 $strHashText 	  = Hash::make(rand());
             Member::where('id', $objMemberData->id)->update([
				'reset_token' => $strHashText,	
				'updated_at' => date('Y-m-d H:i:s')	
			]);	
			
            //send forgot password mail to User
            $strCustomerName    = $objMemberData->first_name.' '.$objMemberData->last_name;
            $strResetPasswordURL = 'reset-password/'.base64_encode($objMemberData->id).'/'.$strHashText;

            $strCustomerMailSubject = config('emailcontents.emails.2.subject');
            $strCustomerMessage     = config('emailcontents.emails.2.message');
            $strCustomerMessage     = str_replace('[USER_NAME]',$strCustomerName, $strCustomerMessage);
            $strCustomerMessage     = str_replace('[USER_PWRESET_URL]', URL::to('/reset-password/'.base64_encode($objMemberData->id).'/'.base64_encode($strHashText)), $strCustomerMessage);
        
            $isSent = sendEmail(trim($objMemberData->email), $strCustomerName, $strCustomerMailSubject,$strCustomerMessage,"");

            return redirect('/forgot-password')->with('success',trans('app.user_pw_link'));
        }
        else {
            return redirect('/forgot-password')->with('danger',trans('app.valid_details'));
        }
	}

	//Set Reset password 
	public function resetPassword($userId,$passToken)
    {
    	if(isset($userId) && isset($passToken)) {
            $objMember = Member::where('id', trim(base64_decode($userId)))->where('isActive', 'y')->where('isDeletedByUser', 'n')->get()->first();

            if(isset($objMember)) {
                if($objMember->reset_token != '') {
                    if($objMember->reset_token == base64_decode($passToken)) {
                    	return view('frontend.resetpassword',compact('passToken','userId'));
                    }
                    return redirect('/');
                }
                else {
                    return redirect('/login')->with('success', trans('app.already_reset_pw'));
                }
            }
            else {
                return redirect('/login')->with('danger',trans('app.valid_details'));
            }
        }
        return redirect('/');
    }

    //Set new password 
    public function setNewPassword(Request $request)
    {
    	//validate form fields
        Validator::make($request->all(), [
            'fp_new_password'  	=> 'required',
            'fp_confirm_password'  => 'required'
        ])->validate();

        $objMemberData = Member::where('id', trim(base64_decode($request->fp_user_id)))->where('isActive', 'y')->where('isDeletedByUser', 'n')->get()->first();

        if(isset($objMemberData)) {
        	if(isset($objMemberData->reset_token)) {
	        	if($request->fp_new_password != $request->fp_confirm_password) {
	      			return redirect('reset-password/'.base64_encode($objMemberData->id).'/'.$request->fp_reset_token)->with('danger', trans('app.pw_match'));
	      		}
	      		else {
	      			if($objMemberData->reset_token == base64_decode($request->fp_reset_token)) {
	      				Member::where('id', $objMemberData->id)->update([
							'reset_token' => NULL,
                            'password'   => Hash::make($request->fp_new_password),	
							'updated_at' => date('Y-m-d H:i:s')	
						]);	
						return redirect('/login')->with('success', trans('app.user_reset_pw'));
	      			}
                    else {
                        return redirect('/login')->with('danger', trans('app.user_pw_token'));
                    }
	      		}
	        }
	        return redirect('/');
        }
        else {
            return redirect('reset-password/'.$request->fp_user_id.'/'.$request->fp_reset_token)->with('danger', trans('app.valid_details'));
        }
    }
}
