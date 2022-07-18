<?php

namespace App\Http\Controllers\Api;

use App\AppUser;
use App\FcmUser;
use App\Http\Controllers\Controller\Api;
use Hash;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\ResetPasswordMail;

class ForgotPasswordController extends ApiController
{
    /*
    |--------------------------------------------------------------------------
    | Forgot Password Controller
    |--------------------------------------------------------------------------
    */   

   	/**
	 * @api {post} /forgot Forgot Password
	 * @apiDescription Send OTP to the registered email address.
	 * @apiGroup Webservices
	 *
	 * @apiVersion 0.1.0
	 * @apiParam {String} email Customer Email Address
	 * 
	 */
    public function forgot(Request $request)
    {
    	//Field validation
		$validator = Validator::make($request->all(), [
		  'email'    	=> 'required|email'
		]);

		//Throw errors if validation fails
		if($validator->fails()) {
			errorResponse($validator->errors()); 
		}

		//check if email is valid and exits in the database
    	$arrUserDetails = AppUser::where('email', $request->email)->first(); 

    	if($arrUserDetails)
    	{
    		if($arrUserDetails->status==config('variables.STATUS_ACTIVE'))
    		{
    			$intUserId 	= $arrUserDetails->id;    			
    			$strToken 	= rand(11111,99999);

    			//update forgot password token into database
				$intUpdateResult = AppUser::where('id', $intUserId)
								->update(['reset_password_token' => $strToken]);				

				$arrUserDetails = AppUser::findOrFail($arrUserDetails->id);
		        
		        $resultMail = Mail::to($arrUserDetails)->send(new ResetPasswordMail($arrUserDetails));

				//return success message
		     	$arrData = array('reset_password_token' => $strToken);
	    		successResponse('OTP sent successfully to the registered email address.', $arrData);
    		}
    		else 
			{
				//return error message if user exits but is inactive
				errorResponse('User is inactive. Please contact admin.');
			}	    		
    	}     
    	else
    	{
    		//return error message if user does not exits
    		errorResponse('User does not exits.');
      	}  	
    }

    /**
	 * @api {post} /resetpassword Reset Password
	 * @apiDescription Allow Customer to reset password.
	 * @apiGroup Webservices
	 *
	 * @apiVersion 0.1.0
	 * @apiParam {String} email Customer Email Address
	 * @apiParam {String} otp OTP
	 * @apiParam {String} new_password New Password
	 * 
	 */
    public function resetpassword(Request $request)
    {
    	//Field validation
		$validator = Validator::make($request->all(), [
		  'email'   		=> 'required|email',
		  'otp'    			=> 'required',
		  'new_password'    => 'required'
		]);

		//Throw errors if validation fails
		if($validator->fails()) {
			errorResponse($validator->errors()); 
		}

		//check if email is valid and exits in the database
    	$arrUserDetails = AppUser::where('email', $request->email)->first(); 

    	if($arrUserDetails)
    	{
    		if($arrUserDetails->reset_password_token==$request->otp)
    		{
    			$intUserId 	= $arrUserDetails->id;    			
    			
    			//update password into database
				$intUpdateResult = AppUser::where('id', $intUserId)
								->update(['password' => Hash::make($request->new_password),'reset_password_token'=>NULL]);				

				if($intUpdateResult)
				{
					//return success message
		     		successResponse('Password updated successfully.');
				}
			}
    		else 
			{
				//return error message if user exits but is inactive
				errorResponse('Invalid OTP.');
			}	    		
    	}     
    	else
    	{
    		//return error message if user does not exits
    		errorResponse('User does not exits.');
      	}  	
    }


    /**
	 * @api {post} /changepassword Change Password
	 * @apiDescription Allow Customer to change the password.
	 * @apiGroup Webservices
	 *
	 * @apiVersion 0.1.0
	 * @apiParam {String} old_password Old Password
	 * @apiParam {String} new_password New Password
	 * @apiParam {String} app_user_id App User Id
	 * 
	 */
    public function changepassword(Request $request)
    {
    	//Field validation
		$validator = Validator::make($request->all(), [
		  'old_password'   	=> 'required',
		  'new_password'    => 'required|min:6',
		  'app_user_id' 	=> 'required|exists:app_users,id',
		]);

		//Throw errors if validation fails
		if($validator->fails()) {
			errorResponse($validator->errors()); 
		}

		$intUserId 	= $request->app_user_id;    			
		
		//get user details
		$arrUserDetails = AppUser::where('id', $intUserId)->first();  

		if(Hash::check($request->old_password,$arrUserDetails->password)) 
		{
			//update password into database
			$intUpdateResult = AppUser::where('id', $intUserId)
							->update(['password' => Hash::make($request->new_password),'reset_password_token'=>NULL]);				

			if($intUpdateResult)
			{
				//return success message
	     		successResponse('Password updated successfully.');
			}
		}
		else 
		{
			//return error message if old password is invalid
			errorResponse('Invalid Old Password.');
		}	    	
    }
}
