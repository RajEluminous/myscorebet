<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: EventController.php
# Created on : JULY 2018
# Purpose: Controller for event management at frontend
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

namespace App\Http\Controllers;
use App\Event;
use App\Subevent;
use App\Member;
use Illuminate\Http\Request;
use App\UserScorePrediction;
use App\WinnersSelection;
use Session;
use Cookie;

class EventController extends Controller
{
    // default call 
    public function index(Request $request)
    {
        //Save user prediction details
        if(!empty($request->input())) {
            $arrTeam1Score      = $request->pred_score_team1;
            $arrTeam2Score      = $request->pred_score_team2;
            $arrSubeventId      = $request->fp_subevent_ids;
            $intUserId          = Session::get('cd_customer_id');
            $strSubEvents       = '';
            
            //Delete existing data if present
            if(!empty($arrTeam1Score)) {
                foreach($arrTeam1Score as $key => $arrTeam1ScoreVal) {
                    if($arrTeam1ScoreVal!='') {
                        // add record in user prediction table
                        $arrUserPredictions = UserScorePrediction::updateOrCreate(
                            ['uid' => $intUserId, 'eventid' => $request->fp_event_id, 'subeventid' => $arrSubeventId[$key]],
                            [
                                'uid'               => $intUserId,
                                'eventid'           => $request->fp_event_id,
                                'subeventid'        => $arrSubeventId[$key],
                                'pred_score_team1'  => $arrTeam1ScoreVal,
                                'pred_score_team2'  => $arrTeam2Score[$key],               
                                'updated_at'        => date('Y-m-d H:i:s'),                
                            ]
                        );

                        $arrSubEvents = Subevent::getSubEventData($arrSubeventId[$key]);
                        if(!empty($arrSubEvents)) {
                            $strSubEvents .= $arrSubEvents->name_team1.' ('.$arrTeam1ScoreVal.') vs '.$arrSubEvents->name_team2.' ('.$arrTeam2Score[$key].'), '; 
                        }
                    }
                }
                
                $strSubEvents = rtrim($strSubEvents,', ');

                //send an email to user for score submission
                if($strSubEvents != '') {
                    $arrUserData = Member::getMemberDetails($intUserId);
                    if(isset($arrUserData)) {
                        $strCustomerName = $arrUserData->first_name.' '.$arrUserData->last_name;
                        
                        //Get event name
                        $arrEventData = Event::getEventData($request->fp_event_id);
                        
                        $strCustomerMailSubject = config('emailcontents.emails.3.subject');
                        $strCustomerMessage     = config('emailcontents.emails.3.message');

                        $strCustomerMessage     = str_replace('[USER_NAME]',$strCustomerName, $strCustomerMessage);
                        $strCustomerMessage     = str_replace('[EVENT_NAME]', $arrEventData->event_name, $strCustomerMessage);
                        $strCustomerMessage     = str_replace('[SUBEVENTS]',$strSubEvents, $strCustomerMessage);

                        $isSent = sendEmail($arrUserData->email, $strCustomerName, $strCustomerMailSubject,$strCustomerMessage,"");
                    }
                }       
            }
            return redirect('/')->with('success',trans('app.user_score_saved'));        
        }
        
        //Get all events
        $event = Event::getAllEvents();

        $arrUserPrediction = UserScorePrediction::userPredictions(Session::get('cd_customer_id'));  
         
        //Get TOP PREDICTORS according to the current month
        $arrTopPredictionsCurrentMonth = UserScorePrediction::getUserScorePredictions(1);

        //Get TOP Winners of last month
        $arrTopWinnersLastMonth = WinnersSelection::getWinners();

        //Get TOP PREDICTORS
        $arrTopPredictions = UserScorePrediction::getUserScorePredictions();
        return view('frontend.home.homeContent',['events' => $event, 'arrTopPredictionsCurrentMonth' => $arrTopPredictionsCurrentMonth, 'arrTopPredictions' => $arrTopPredictions, 'arrUsrPred' => $arrUserPrediction, 'arrTopWinnersLastMonth' => $arrTopWinnersLastMonth]);
    }
}