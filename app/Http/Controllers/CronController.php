<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: CronController.php
# Created on : JULY 2018
# Purpose: Controller for set up cron jobs for website
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

namespace App\Http\Controllers;
use DB;
use App\Member;
use App\Event;
use App\Subevent;
use App\UserScorePrediction;
use Illuminate\Http\Request;

class CronController extends Controller
{
	//send an email for all members which will have valid score
	public function userScorePridictionMailSend()
    {	 		 
    	//Get all memebers
    	$arrMembers = array();
    	$strSubEvents = $strAdminScore = '';
    	$arrMembers = UserScorePrediction::from('user_score_prediction as usp')
                ->leftJoin('members as m','usp.uid', '=', 'm.id')
                ->select('usp.uid','m.email','m.first_name','m.last_name','usp.id', 'usp.eventid', 'usp.subeventid','usp.pred_score_team1', 'usp.pred_score_team2')
                ->where([
                            ['usp.isValid','=','y'],
                            ['usp.isEmailSend','=','n']
                            ['m.isActive','=','y'],
                            ['m.isDeletedByUser','=','n']
                        ])
         		->orderBy('usp.uid', 'asc')
                ->get();

        if(count($arrMembers)>0) {
        	foreach ($arrMembers as $item) {
        		  //send mail to member
	            $strCustomerName  		= $item->first_name.' '.$item->last_name;
	            
	            //Get event name
    			$arrEventData = Event::getEventData($item->eventid);
    			$arrSubEvents = Subevent::getSubEventData($item->subeventid);

    			if(!empty($arrSubEvents)) {
    				$strSubEvents	= '<strong>'.$arrSubEvents->name_team1.' vs '.$arrSubEvents->name_team2.'</strong>';

    				$strAdminScore	= $arrSubEvents->name_team1.' ('.$arrSubEvents->score_team1.') & '.$arrSubEvents->name_team2.' ('.$arrSubEvents->score_team2.')';
    			}

    			$strUserScore			= $arrSubEvents->name_team1.' ('.$item->pred_score_team1.') & '.$arrSubEvents->name_team2.' ('.$item->pred_score_team2.')';

	            $strCustomerMailSubject = config('emailcontents.emails.4.subject');
	            $strCustomerMessage     = config('emailcontents.emails.4.message');

	            $strCustomerMessage     = str_replace('[USER_NAME]',$strCustomerName, $strCustomerMessage);
	            $strCustomerMessage     = str_replace('[EVENT_NAME]', $arrEventData->event_name, $strCustomerMessage);
		        $strCustomerMessage     = str_replace('[SUBEVENTS]',$strSubEvents, $strCustomerMessage);
		        $strCustomerMessage     = str_replace('[USER_SCORE]',$strUserScore, $strCustomerMessage);
		        $strCustomerMessage     = str_replace('[ADMIN_SCORE]',$strAdminScore, $strCustomerMessage);
		 	        
	            $isSent = sendEmail($item->email, $strCustomerName, $strCustomerMailSubject,$strCustomerMessage,"");

	            //update mail status if mail send
          		$updateMailStatus = UserScorePrediction::where('id',$item->id)
                                  ->update(['isEmailSend' => 'y']);
        	}

        	//Create file to check if mail is Okay or not
	        $file = public_path() . '/files/cron-file/'.'winning_score.txt';
	        // Append a new person to the file
			$content = "Email send successfully";
			// Write the contents back to the file
			file_put_contents($file, $content);
        }
		exit;
	}
}
