<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Member;
use Illuminate\Http\Request;
use Validator;
use Hash;

class ForgotpasswordController extends Controller
{
	// default call	
	public function index()
    {	 		 
		return view('frontend.forgotpasswordContent'); 				 
	}	

	//Set Forgot password link
	public function setpass(Request $request)
    {	 
    	//validate form fields
        Validator::make($request->all(), [
            'fp_useremail'  => 'required'
        ])->validate();

        $objMemberData = Member::where('email', trim($request->fp_useremail))->where('isActive', 'y')->get()->first();
        if(isset($objMemberData)) {
             //Update token in database for member
        	 $strHashText 	  = Hash::make(rand());
             Member::where('id', $objMemberData->id)->update([
				'reset_token' => $strHashText,	
				'updated_at' => date('Y-m-d H:i:s')	
			]);	

            //send forgot password mail to User
            $strCustomerName  = $objMemberData->first_name.' '.$objMemberData->last_name;
            $strResetPasswordURL = url('reset-password/'.base64_encode($objMemberData->id).'/'.$strHashText);

            $strCustomerMailSubject = config('emailcontents.emails.2.subject');
            $strCustomerMessage     = config('emailcontents.emails.2.message');
            $strCustomerMessage     = str_replace('[USER_NAME]',$strCustomerName, $strCustomerMessage);
            $strCustomerMessage     = str_replace('[USER_PWRESET_URL]', $strResetPasswordURL, $strCustomerMessage);
        
            $isSent = sendEmail($objMemberData->email, $strCustomerName, $strCustomerMailSubject,$strCustomerMessage,"");

            return redirect('/forgot-password')->with('success','We have e-mailed your password reset link!');
        }
        return redirect('/');	
	}

	//Set Reset password 
	public function resetPass($userId,$passToken=null)
    {
    	if(isset($userId) && isset($passToken)) {
            $objMember = Member::findOrFail(base64_decode($userId));
            if(isset($objMember)) {
                if($objMember->reset_token != '') {
                    if($objMember->reset_token == $passToken) {
                    	return view('frontend.resetpassword',compact('passToken'));
                    }
                    return redirect('/');
                }
                else {
                    return redirect('/login')->with('success','We already changed your password. Please login here');
                }
            }
            return redirect('/');
        }
        return redirect('/');
    }

    //Set new password 
    public function setNewPassword(Request $request)
    {
    	//validate form fields
        Validator::make($request->all(), [
            'fp_useremail'  	=> 'required',
            'fp_new_password'  	=> 'required',
            'fp_confirm_password'  => 'required'
        ])->validate();

        $objMemberData = Member::where('email', $request->fp_useremail)->get()->first();
        if(isset($objMemberData)) {
        	if(isset($objMemberData->reset_token)) {
	        	if($request->fp_new_password != $request->fp_confirm_password) {
	      			return redirect('reset-password/'.base64_encode($objMemberData->id).'/'.$request->fp_reset_token)->with('danger','New password & confirm password doesnt match.');
	      		}
	      		else {
	      			if($objMemberData->reset_token == $request->fp_reset_token) {
	      				Member::where('id', $objMemberData->id)->update([
							'reset_token' => NULL,	
							'updated_at' => date('Y-m-d H:i:s')	
						]);	
						return redirect('/login')->with('success','We have changed your password. Please login here.');
	      			}
	      			return redirect('/');
	      		}
	        }
	        return redirect('/');
        }
    }
}
