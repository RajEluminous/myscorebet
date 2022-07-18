<?php

namespace App\Http\Controllers\Api;

use App\AppUser;
use App\FcmUser;
use App\Http\Controllers\Controller\Api;
use Hash;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Language;

class LoginController extends ApiController
{
    /**
	 * @api {post} /login App Login
	 * @apiDescription Handle a login request to the mobile application.
	 * @apiGroup Webservices
	 *
	 * @apiVersion 0.1.0
	 * @apiParam {String} username Username.
	 * @apiParam {String} password Password.
	 * @apiParam {String} token One Signal Token.
	 * @apiParam {String} imei_number Device Unique Id.
	 * @apiParam {String} device_type Device Type ios or android.
	 * 
	 */
    public function login(Request $request)
    {
    	//Field validation
		$validator = Validator::make($request->all(), [
		  'username'	=> 'required',
		  'password'    => 'required',
		  'token'    	=> 'required',
		  'imei_number'	=> 'required',
		  'device_type'	=> 'required'
		]);

		//Throw errors if validation fails
		if($validator->fails()) {
			errorResponse($validator->errors()); 
		}

		$strUsername 	= $request->username;
    	$strPassword 	= $request->password;
    	$strToken 	 	= $request->token;
    	$strImeiNumber 	= $request->imei_number;
    	$strDeviceType 	= $request->device_type;

    	//check if username is valid
    	$arrUserDetails = AppUser::where('username', $strUsername)->orWhere('email', $strUsername)->first();   
    	
    	if($arrUserDetails)
    	{
    		if($arrUserDetails->status==config('variables.STATUS_ACTIVE'))
    		{
    			//match password with database record
	    		if(Hash::check($strPassword,$arrUserDetails->password)) 
		    	{
	    			$intUserId 		= $arrUserDetails->id;

	    			//check if token exits for the device of same user. If exits the update token else add new record with the device details
					$arrFcmDetails = FcmUser::updateOrCreate(
	    				['imei_number' => $strImeiNumber, 'user_id' => $intUserId],
	    				[
	    					'user_id' => $intUserId,
	    					'token' => $strToken,
	    					'imei_number' => $strImeiNumber,
	    					'device_type' => $strDeviceType
	    				]
					);

					//get languages 
		           	$arrLanguages	= Language::pluck('name','code');

					$arrData = array('user_details' => $arrUserDetails, 'languages' => $arrLanguages);

					//return success message
		    		successResponse('User has been validated successfully.', $arrData);
				} 
				else 
				{
					//return error message if password is invalid
				   	errorResponse('Invalid password');
				}	
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
}
